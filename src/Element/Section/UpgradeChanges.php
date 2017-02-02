<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;
use Symfony\Component\Finder\Finder;

class UpgradeChanges implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Review upgrade changes and fix possible customization conflicts';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    public function isRelevantTo(Context $context)
    {
        return $context->getPackagesPath()
            && $this->getFlavPackages($context->getFlav(), $context->getPackagesPath());
    }

    /**
     * @param Context $context
     *
     * @return string
     */
    public function getBody(Context $context)
    {
        return $this->renderer->render('upgrade_changes', [
            'packages' => $this->getSuitablePackages($context),
            'upgrade_to' => $context->getUpgradeVersion(),
            'packages_path' => $context->getPackagesPath(),
        ]);
    }

    /**
     * @param Context $context
     *
     * @return array
     */
    private function getSuitablePackages(Context $context)
    {
        $chains = $this->getUpgradeChains(
            $this->getFlavPackages($context->getFlav(), $context->getPackagesPath()),
            $context->getBuildVersion(),
            $context->getUpgradeVersion()
        );

        if (!$chains) {
            return [];
        }

        usort($chains, function ($a1, $a2) {
            return count($a1) < count($a2) ? -1 : (count($a1) > count($a2) ? 1 : 0);
        });

        return $chains[0];
    }

    /**
     * Gets flav specific packages
     *
     * @param $flav
     * @param $packagesPath
     *
     * @return array
     */
    private function getFlavPackages($flav, $packagesPath)
    {
        $versionPattern = '/\d+\.\d+(\.\d+|\.x){1,2}/';
        $packagePattern = sprintf('/^Sugar%1$s-Upgrade-%2$s-to-%2$s.zip$/',
            ucfirst(mb_strtolower($flav)),
            trim($versionPattern, '/')
        );

        $packagesIterator = (new Finder())->files()->in($packagesPath)->name($packagePattern);

        $packages = [];
        foreach ($packagesIterator as $package) {
            if (preg_match_all($versionPattern, $package, $matches)) {
                $packages[$package->getFilename()] = [
                    'path' => $package->getRealPath(),
                    'from' => str_replace('.x', '', $matches[0][0]),
                    'to' => str_replace('.x', '', $matches[0][1])
                ];
            }
        }

        return $packages;
    }

    /**
     * Calculates an array of possible upgrade chains
     *
     * @param $packages
     * @param $buildVersion
     * @param $upgradeTo
     *
     * @return array
     */
    private function getUpgradeChains($packages, $buildVersion, $upgradeTo)
    {
        $versionMatrix = $this->getVersionMatrix($packages);
        $allVersions = array_keys($versionMatrix);

        $getExistingSubversions = function ($version) use ($allVersions) {
            $existingVersions = [];

            $fromParts = explode('.', $version);
            foreach (range(2, count($fromParts)) as $length) {
                $subversion = implode('.', array_slice($fromParts, 0, $length));
                if (in_array($subversion, $allVersions)) {
                    $existingVersions[] = $subversion;
                }
            }

            return $existingVersions;
        };

        // init chains with starting versions
        $chains = array_map(function ($version) use ($buildVersion) {
            return [$version => $buildVersion];
        }, $getExistingSubversions($buildVersion));

        // finish early if starting / ending version doesn't exist
        if (!$chains || !in_array($upgradeTo, $allVersions)) {
            return [];
        }

        // gets last key of assoc array
        $getLastKey = function ($array) {
            end($array);

            return key($array);
        };

        // find all chains
        while (true) {
            $fullChains = [];
            foreach ($chains as $index => $chain) {
                $fromVersion = $getLastKey($chain);

                // skip not interesting chains
                if (version_compare($fromVersion, $upgradeTo, '>=')) {
                    continue;
                }

                $validChain = false;
                foreach ($allVersions as $version) {
                    if (!empty($versionMatrix[$fromVersion][$version])) {
                        $to = $getExistingSubversions($version);
                        foreach ($to as $toVersion) {

                            if ($toVersion === $fromVersion
                                || version_compare($toVersion, $upgradeTo, '>')
                                || $chain[$getLastKey($chain)] === $version
                            ) {
                                continue;
                            }

                            $validChain = true;
                            $fullChains[] = array_merge($chain, [$toVersion => $version]);
                        }
                    }
                }

                // remove invalid chain
                if (!$validChain) {
                    unset($chains[$index]);
                }
            }

            if (!$fullChains) {
                break;
            }

            $chains = $fullChains;
        }

        $chains = array_map(function ($chain) use ($versionMatrix) {
            $keys = array_keys($chain);
            $values = array_values($chain);

            $packages = [];
            foreach (range(1, count($keys) - 1) as $index) {
                $packages[] = $versionMatrix[$keys[$index - 1]][$values[$index]];
            }

            return $packages;
        }, array_values($chains));

        return $chains;
    }

    /**
     * Creates version matrix
     *
     *       v1       v2       v3       v4
     *  v1    0     <path>   <path>      0
     *  v2    0        0     <path>      0
     *  v3    0        0        0     <path>
     *  v4    0        0        0        0
     *
     * @param $packages
     *
     * @return array
     */
    private function getVersionMatrix($packages)
    {
        $allVersions = array_unique(call_user_func_array('array_merge', array_map(function ($package) {
            return [$package['from'], $package['to']];
        }, $packages)));

        // sort versions (ASC)
        usort($allVersions, function ($v1, $v2) {
            return version_compare($v1, $v2, '<') ? -1 : (version_compare($v1, $v2, '>') ? 1 : 0);
        });

        // create matrix and fill it with zeros
        $versionMatrix = call_user_func_array('array_merge',array_map(function ($version) use ($allVersions) {
            return [$version => array_combine($allVersions, array_fill(0, count($allVersions), 0))];
        }, $allVersions));

        // valid associations point to package path
        foreach ($packages as $name => $package) {
            $versionMatrix[$package['from']][$package['to']] = $package['path'];
        }

        return $versionMatrix;
    }
}

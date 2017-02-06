<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider\SourceCode;

use Sugarcrm\UpgradeSpec\Data\Exception\WrongProviderException;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Symfony\Component\Finder\Finder;

class LocalUpgradePackages implements SourceCodeProviderInterface
{
    /**
     * @var null|array
     */
    private $suitablePackages = null;

    /**
     * Gets the list of potentially broken customizations (changed and deleted files)
     *
     * @param Upgrade $context
     *
     * @return mixed
     */
    public function getPotentiallyBrokenCustomizations(Upgrade $context)
    {
        $packages = $this->getSuitablePackages($context);

        return $this->getChangedFiles('/Users/m.kamornikov/Dev/sugarcrm/build/rome/builds/ult/sugarcrm', $packages);
    }

    /**
     * Gets the lists of upgrade steps for the given source
     *
     * @param Upgrade $context
     *
     * @return mixed
     * @throws WrongProviderException
     */
    public function getUpgradeSteps(Upgrade $context)
    {
        if (file_exists($context->getTargetPath() . '/.git')) {
            throw new WrongProviderException('This provider uses zipped upgrade packages as source');
        }

        return $this->getSuitablePackages($context);
    }

    /**
     * @param $buildPath
     * @param $packages
     *
     * @return array
     */
    private function getChangedFiles($buildPath, $packages)
    {
        $modifiedFiles = $deletedFiles = $packageZips = [];

        foreach ($packages as $package) {
            $zip = new \ZipArchive();
            if (!$zip->open($package)) {
                throw new \RuntimeException(sprintf('Can\'t open zip archive: %s', $package));
            }

            $packageZips[$package] = $zip;

            eval(str_replace(['<?php', '<?', '?>'], '', $zip->getFromName(basename($package, '.zip') . DS . 'files.md5')));
            $packageModifiedFiles = array_keys($md5_string);

            if ($filesToRemove = $zip->getFromName('filesToRemove.txt')) {
                $packageDeletedFiles = explode(PHP_EOL, str_replace(["\r\n", "\r", "\n"], PHP_EOL, $filesToRemove));
            } else if ($filesToRemove = $zip->getFromName('filesToRemove.json')) {
                $packageDeletedFiles = json_decode($filesToRemove);
            } else {
                throw new \RuntimeException('Can\'t open filesToRemove');
            }

            $modifiedFiles = array_merge($modifiedFiles, array_combine($packageModifiedFiles, array_fill(0, count($packageModifiedFiles), $package)));
            $deletedFiles = array_diff(array_merge($deletedFiles, $packageDeletedFiles), $packageModifiedFiles);
        }

        $modifiedFiles = array_keys(array_filter($modifiedFiles, function ($package, $changedFile) use ($buildPath, $packageZips) {
            if (($buildFile = @file_get_contents($buildPath . DS . $changedFile)) === false) {
                return false;
            }
            $packageFile = $packageZips[$package]->getFromName(basename($package, '.zip') . DS . $changedFile);

            return $this->getCheckSum($buildFile) != $this->getCheckSum($packageFile);
        }, ARRAY_FILTER_USE_BOTH));

        $deletedFiles = array_values(array_filter($deletedFiles));

        foreach ($packageZips as $zip) {
            $zip->close();
        }

        $modifiedFiles = array_values(array_filter($modifiedFiles, function ($file) use ($buildPath) {
            return file_exists($buildPath . '/custom/' . $file);
        }));

        $deletedFiles = array_values(array_filter($deletedFiles, function ($file) use ($buildPath) {
            return file_exists($buildPath . '/custom/' . $file);
        }));

        natsort($modifiedFiles);
        natsort($deletedFiles);

        return ['modified_files' => $modifiedFiles, 'deleted_files' => $deletedFiles];
    }

    /**
     * @param Upgrade $context
     *
     * @return array
     */
    private function getSuitablePackages(Upgrade $context)
    {
        if (!is_null($this->suitablePackages)) {
            return $this->suitablePackages;
        }

        $upgradeChains = $this->getUpgradeChains(
            $this->getFlavPackages($context->getBuildFlav(), $context->getTargetPath()),
            $context->getBuildVersion(),
            $context->getTargetVersion()
        );

        if (!$upgradeChains) {
            $this->suitablePackages = [];

            return $this->suitablePackages;
        }

        usort($upgradeChains, function ($a1, $a2) {
            return count($a1) < count($a2) ? -1 : (count($a1) > count($a2) ? 1 : 0);
        });

        $this->suitablePackages = $upgradeChains[0];

        return $upgradeChains[0];
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
     * @param $content
     *
     * @return string
     */
    private function getCheckSum($content)
    {
        // remove license comments
        $content = preg_replace('/\/\*.*?Copyright \(C\) SugarCRM.*?\*\//is', '', $content);

        // remove blank lines
        $content = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', "\n", $content);

        // change all line breaks to system line break
        $content = str_replace(["\r\n", "\r", "\n"], PHP_EOL, $content);

        // remove trailing whitespaces
        $content = preg_replace('/^\s+|\s+$/m', '', $content);

        return md5($content);
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
        // quit early
        if (!$packages) {
            return [];
        }

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

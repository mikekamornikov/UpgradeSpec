<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider\SourceCode;

use Sugarcrm\UpgradeSpec\Data\Exception\WrongProviderException;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Version\Graph\AdjacencyList;
use Sugarcrm\UpgradeSpec\Version\Graph\Dijkstra;
use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;
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

        return $this->getChangedFiles($context->getBuildPath(), $packages);
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

        $packages = $this->getFlavPackages($context->getBuildFlav(), $context->getTargetPath());
        $graph = new Dijkstra(new AdjacencyList($packages));

        $this->suitablePackages = array_map(function (array $hop) use ($packages) {
            foreach ($packages as $path => $pair) {
                if ((new OrderedList($hop))->isEqualTo(new OrderedList($pair))) {
                    return $path;
                }
            }

            throw new \RuntimeException(sprintf('Package not found: "%s"', $hop));
        }, $graph->getPath($context->getBuildVersion(), $context->getTargetVersion()));

        return $this->suitablePackages;
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
        $flav = ucfirst(mb_strtolower($flav));
        $packagePattern = sprintf('/^Sugar%1$s-Upgrade-%2$s-to-%2$s.zip$/', $flav, trim($versionPattern, '/'));

        $packages = [];
        foreach ((new Finder())->files()->in($packagesPath)->name($packagePattern) as $package) {
            if (preg_match_all($versionPattern, $package, $matches)) {
                $packages[$package->getRealPath()] = [
                    new Version(str_replace('.x', '', $matches[0][0])),
                    new Version(str_replace('.x', '', $matches[0][1]))
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
}

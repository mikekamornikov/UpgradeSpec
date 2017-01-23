<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Data\Manager;

use Sugarcrm\UpgradeSpec\Template\RendererInterface;
use Symfony\Component\Finder\Finder;

class Provider
{
    /**
     * @var RendererInterface
     */
    private $templateRenderer;

    /**
     * @var Manager
     */
    private $dataManager;

    /**
     * Configurator constructor.
     *
     * @param RendererInterface $templateRenderer
     * @param Manager           $dataManager
     */
    public function __construct(RendererInterface $templateRenderer, Manager $dataManager)
    {
        $this->templateRenderer = $templateRenderer;
        $this->dataManager = $dataManager;
    }

    /**
     * @param $buildVersion
     * @param $upgradeTo
     *
     * @return array
     */
    public function getElements($buildVersion, $upgradeTo)
    {
        $elements = $this->getSuitableElements($buildVersion, $upgradeTo);

        if (!$elements) {
            throw new \DomainException(sprintf('No special steps required to upgrade from "%s" to "%s")',
                $buildVersion,
                $upgradeTo
            ));
        }

        return $elements;
    }

    /**
     * @param $oldVersion
     * @param $newVersion
     *
     * @return array
     */
    private function getSuitableElements($oldVersion, $newVersion)
    {
        // list of potential elements (FQCNs)
        $classNames = [];
        foreach (Finder::create()->files()->in(__DIR__ . '/Section')->name('*.php') as $file) {
            list($className, ) = explode('.', $file->getBasename());
            $classNames[] = '\\Sugarcrm\\UpgradeSpec\\Element\\Section\\' . $className;
        }

        // list of relevant elements (FQCNs)
        $classNames = array_filter($classNames, function ($className) use ($oldVersion, $newVersion) {
            return (new \ReflectionClass($className))->implementsInterface(ElementInterface::class)
                && $className::isRelevantTo($oldVersion, $newVersion);
        });

        // element factory
        $elements = array_map(function ($className) {
            $element = new $className();

            $reflectionClass = new \ReflectionClass($className);
            if ($reflectionClass->implementsInterface(RendererAwareInterface::class)) {
                $element->setRenderer($this->templateRenderer);
            }
            if ($reflectionClass->implementsInterface(DataAwareInterface::class)) {
                $element->setDataManager($this->dataManager);
            }

            return $element;
        }, $classNames);

        // sort elements (ASC)
        usort($elements, function (ElementInterface $a, ElementInterface $b) {
            return $a->getOrder() > $b->getOrder() ? 1 : ($a->getOrder() < $b->getOrder() ? -1 : 0);
        });

        return $elements;
    }
}

<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class CheckCustomizations implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Analyze customizations';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    public static function isRelevantTo(Context $context)
    {
        return true;
    }

    /**
     * @param Context $context
     *
     * @return string
     */
    public function getBody(Context $context)
    {
        return $this->renderer->render('check_customizations', [
            'check_customizations' => $this->getListOfCustomizations($context),
        ]);
    }


    /**
     * Get all available SugarCRM versions (sorted ASC).
     *
     * @param mixed $flav
     *
     * @return mixed
     */
    public function getListOfCustomizations($pathToUpgradePackage)
    {
        $customizations = array();
        $customizations['deleted_files'] =  $this->getListOfDeletedFiles($pathToUpgradePackage);
        $customizations['modified_files'] =  $this->getListOfModifiedFiles($pathToUpgradePackage);
        $customizations['post_scripts'] =  $this->getListOfScripts($pathToUpgradePackage);
        $customizations['sql_scripts'] =  $this->getListOfSQLScripts($pathToUpgradePackage);

        return $customizations;
    }

    /**
     * Get list of files needs to be deleted
     *
     * @param String $pathToUpgradePackage
     *
     * @return mixed
     */
    public function getListOfDeletedFiles($pathToUpgradePackage)
    {
        return '';
    }

    /**
     * Get list of files needs to be Modified
     *
     * @param String $pathToUpgradePackage
     *
     * @return mixed
     */
    public function getListOfModifiedFiles($pathToUpgradePackage)
    {
        return '';
    }


    /**
     * Get list of scripts needs to be run for upgrade
     *
     * @param String $pathToUpgradePackage
     *
     * @return mixed
     */
    public function getListOfScripts($pathToUpgradePackage)
    {
        return '';
    }

    /**
     * Get list of sql migration scripts needs to be run for upgrade
     *
     * @param String $pathToUpgradePackage
     *
     * @return mixed
     */
    public function getListOfSQLScripts($pathToUpgradePackage)
    {
        return '';
    }
}

<?php

namespace Sugarcrm\UpgradeSpec;

use League\HTMLToMarkdown\HtmlConverter;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Command\PharContext;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Data\Provider\LocalUpgradePackage;
use Sugarcrm\UpgradeSpec\Data\Provider\SupportSugarcrm;
use Sugarcrm\UpgradeSpec\Data\ProviderChain;
use Sugarcrm\UpgradeSpec\Element\Generator as ElementGenerator;
use Sugarcrm\UpgradeSpec\Element\Provider;
use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Template\TwigRenderer;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Twig_Loader_Filesystem;

final class Application extends BaseApplication
{
    /**
     * Gets full version name.
     *
     * @return string
     */
    public function getLongVersion()
    {
        $art = <<<EOL
      ___            ___            ___          ___            ___     
     /__/\          /  /\          /  /\        /  /\          /  /\    
     \  \:\        /  /:/_        /  /::\      /  /:/_        /  /:/    
      \  \:\      /  /:/ /\      /  /:/\:\    /  /:/ /\      /  /:/     
  ___  \  \:\    /  /:/ /::\    /  /:/~/:/   /  /:/ /:/_    /  /:/  ___ 
 /__/\  \__\:\  /__/:/ /:/\:\  /__/:/ /:/   /__/:/ /:/ /\  /__/:/  /  /\
 \  \:\ /  /:/  \  \:\/:/~/:/  \  \:\/:/    \  \:\/:/ /:/  \  \:\ /  /:/
  \  \:\  /:/    \  \::/ /:/    \  \::/      \  \::/ /:/    \  \:\  /:/ 
   \  \:\/:/      \__\/ /:/      \  \:\       \  \:\/:/      \  \:\/:/  
    \  \::/         /__/:/        \  \:\       \  \::/        \  \::/   
     \__\/          \__\/          \__\/        \__\/          \__\/    
EOL;

        return sprintf('<info>%s</info>', $art) . PHP_EOL . PHP_EOL . parent::getLongVersion() . ' by <comment>Mike Kamornikov</comment> and <comment>Denis Stiblo</comment>';
    }

    public function add(Command $command)
    {
        if (($command instanceof PharContext) && !$this->isPharContextAllowed()) {
            return null;
        }

        return parent::add($command); // TODO: Change the autogenerated stub
    }

    /**
     * Defines if it's called from phar.
     *
     * @return bool
     */
    private function isPharContextAllowed()
    {
        return \Phar::running() || (bool) getenv('DEV_MODE');
    }
}

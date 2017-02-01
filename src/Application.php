<?php

namespace Sugarcrm\UpgradeSpec;

use Sugarcrm\UpgradeSpec\Command\PharContext;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;

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

        return parent::add($command);
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

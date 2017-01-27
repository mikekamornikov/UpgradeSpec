<?php

namespace features\Sugarcrm\UpgradeSpec\Context;

use Behat\Behat\Context\Context;
use PHPUnit_Framework_Assert;
use Sugarcrm\UpgradeSpec\Application;
use Symfony\Component\Console\Tester\CommandTester;

class FeatureContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var
     */
    private $tester;

    /**
     * FeatureContext constructor.
     */
    public function __construct()
    {
        if (false === @copy(realpath(__DIR__ . '/../../bin/uspec.pubkey'), BEHAT_BIN_PATH . '.pubkey')) {
            throw new \RuntimeException('Application public key is not available');
        }

        $this->application = new Application('SugarCRM upgrade spec generator', '@test');
    }

    /**
     * FeatureContext destructor.
     */
    public function __destruct()
    {
        @unlink(BEHAT_BIN_PATH . '.pubkey');
    }

    /**
     * @When /^I run "([^"]*)" command$/
     */
    public function iRunCommand($name)
    {
        $command = $this->application->find($name);

        $this->tester = new CommandTester($command);
        $this->tester->execute(array('command' => $command->getName()));
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($regexp)
    {
        return call_user_func_array(
            [PHPUnit_Framework_Assert::class, 'assertRegExp'],
            [$regexp, $this->tester->getDisplay()]
        );
    }
}

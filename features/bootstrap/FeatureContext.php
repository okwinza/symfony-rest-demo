<?php

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Behat\Context\Context;

/**
 * This context class contains the definitions of the steps used by the demo 
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 * 
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    private $manager;
    private $schemaTool;
    private $classes;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->manager = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');

        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
        $this->schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->manager);
    }

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        echo '-- DROP SCHEMA -- ' . "\n\n\n";
        $this->schemaTool->dropDatabase();

        echo '-- CREATE SCHEMA -- ' . "\n\n\n";
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @BeforeScenario
     */
    public function loadFixtures()
    {
        $container = $this->kernel->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $fixtures = new \App\DataFixtures\AppFixtures();
        $loader = new \Doctrine\Common\DataFixtures\Loader();
        $loader->addFixture($fixtures);

        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger();
        $purger->setPurgeMode(\Doctrine\Common\DataFixtures\Purger\ORMPurger::PURGE_MODE_DELETE);

        $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());

    }

}

<?php

namespace I22\FunctionalTestBundle\Test;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    /** @var Client */
    protected $client;

    /** @var ManagerRegistry */
    protected $doctrine;

    /**
     * @throws \ReflectionException
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->doctrine = $this->client->getContainer()->get('doctrine');
        $this->doctrine->getManager()->getConnection()->getConfiguration()->setSQLLogger(null);

        $this->loadFixtures();
        $this->doctrine->getManager()->clear();
    }

    /**  */
    public function tearDown()
    {
        $this->resetDatabase();
        $this->doctrine->getManager()->clear();
        unset($this->client, $this->doctrine, $this->objects);
        parent::tearDown();
    }

    /**
     * @return Client
     */
    protected function getWebTestClient(): Client
    {
        return $this->client;
    }

    /**
     * @return ManagerRegistry
     */
    protected function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }

    /**
     * Fixtures in the fixtures folder within the test folder will be loaded automatically as long
     * as they are provided in .y(a)ml or php format.
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function getFixtureFilePaths() : array
    {
        $path = $this->getFixtureFileDir();
        if (false === is_dir($path)) {
            return [];
        }

        $files = SymfonyFinder::create()->files()->in($path)->depth(0)->name('/.*\.(ya?ml|php)$/i');

        $fixtureFiles = [];
        foreach ($files as $file) {
            $fixtureFiles[] = $file->getRealPath();
        }

        return $fixtureFiles;
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function getFixtureFileDir() : string
    {
        $rc = new \ReflectionClass(get_class($this));

        return dirname($rc->getFileName()).DIRECTORY_SEPARATOR.'fixtures';
    }

    /**  */
    private function resetDatabase()
    {
        $purger = new ORMPurger($this->doctrine->getManager());
        $this->doctrine->getConnection()->executeUpdate("SET foreign_key_checks = 0;");
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
        $this->doctrine->getConnection()->executeUpdate("SET foreign_key_checks = 1;");
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function loadFixtures() : array
    {
        $fixtureLoader = $this->client->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');

        return $fixtureLoader->load($this->getFixtureFilePaths());
    }


}

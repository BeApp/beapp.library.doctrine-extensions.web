<?php

namespace Beapp\Doctrine\Extension;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

abstract class DbTestCase extends TestCase
{
    /** @var EntityManagerInterface */
    public $entityManager;
    /** @var Configuration */
    protected $configuration;

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    protected function setUp()
    {
        $this->configuration = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/Entities'], true, null, null, false);
        $this->configureDb($this->configuration);

        $this->entityManager = EntityManager::create(['driver' => 'pdo_sqlite', 'memory' => true], $this->configuration);
    }

    protected abstract function configureDb(Configuration $configuration);

}

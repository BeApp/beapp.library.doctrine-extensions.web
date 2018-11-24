<?php

namespace Beapp\Doctrine\Extension\Functions;

use Beapp\Doctrine\Extension\DbTestCase;
use Doctrine\ORM\Configuration;

class MatchAgainstFunctionTest extends DbTestCase
{

    protected function configureDb(Configuration $configuration)
    {
        $configuration->addCustomNumericFunction(MatchAgainstFunction::MATCH_AGAINST, MatchAgainstFunction::class);
    }

    public function testSqlBuild_literal()
    {
        $query = $this->entityManager->createQuery("SELECT MATCH_AGAINST(d.name, 'test') FROM Beapp\\Doctrine\\Extension\\Entities\\DummyEntity d");
        $this->assertEquals("SELECT MATCH (d0_.name) AGAINST ('test') AS sclr_0 FROM DummyEntity d0_", $query->getSQL());

        $query = $this->entityManager->createQuery("SELECT MATCH_AGAINST(d.name, d.description, 'test') FROM Beapp\\Doctrine\\Extension\\Entities\\DummyEntity d");
        $this->assertEquals("SELECT MATCH (d0_.name, d0_.description) AGAINST ('test') AS sclr_0 FROM DummyEntity d0_", $query->getSQL());
    }

    public function testSqlBuild_argument()
    {
        $query = $this->entityManager->createQuery("SELECT MATCH_AGAINST(d.name, :search) FROM Beapp\\Doctrine\\Extension\\Entities\\DummyEntity d");
        $this->assertEquals("SELECT MATCH (d0_.name) AGAINST (?) AS sclr_0 FROM DummyEntity d0_", $query->getSQL());

        $query = $this->entityManager->createQuery("SELECT MATCH_AGAINST(d.name, d.description, :search) FROM Beapp\\Doctrine\\Extension\\Entities\\DummyEntity d");
        $this->assertEquals("SELECT MATCH (d0_.name, d0_.description) AGAINST (?) AS sclr_0 FROM DummyEntity d0_", $query->getSQL());
    }

}

<?php

namespace Beapp\Doctrine\Extension\Functions;

use Beapp\Doctrine\Extension\DbTestCase;
use Doctrine\ORM\Configuration;

class GeoDistanceFunctionTest extends DbTestCase
{

    protected function configureDb(Configuration $configuration)
    {
        $configuration->addCustomNumericFunction('GEO_DISTANCE', GeoDistanceFunction::class);
    }

    public function testSqlBuild_onlyArithmetic()
    {
        $query = $this->entityManager->createQuery('SELECT GEO_DISTANCE(48.8589506, 2.2768489, 40.6976633,-74.1201068) FROM Beapp\Doctrine\Extension\Entities\DummyEntity d');

        $this->assertEquals('SELECT ACOS(SIN(RADIANS(48.8589506)) * SIN(RADIANS(40.6976633)) + COS(RADIANS(48.8589506)) * COS(RADIANS(40.6976633)) * COS(RADIANS(-74.1201068) - RADIANS(2.2768489))) * 6371000 AS sclr_0 FROM DummyEntity d0_', $query->getSQL());
    }

    public function testSqlBuild_withFields()
    {
        $query = $this->entityManager->createQuery('SELECT GEO_DISTANCE(48.8589506, 2.2768489, d.latitude, d.longitude) FROM Beapp\Doctrine\Extension\Entities\DummyEntity d');

        $this->assertEquals('SELECT ACOS(SIN(RADIANS(48.8589506)) * SIN(RADIANS(d0_.latitude)) + COS(RADIANS(48.8589506)) * COS(RADIANS(d0_.latitude)) * COS(RADIANS(d0_.longitude) - RADIANS(2.2768489))) * 6371000 AS sclr_0 FROM DummyEntity d0_', $query->getSQL());
    }

    public function testSqlBuild_withComputedFields()
    {
        $query = $this->entityManager->createQuery('SELECT GEO_DISTANCE(48.8589506, 2.2768489, d.latitude - 1.0, d.longitude + 1.0) FROM Beapp\Doctrine\Extension\Entities\DummyEntity d');

        $this->assertEquals('SELECT ACOS(SIN(RADIANS(48.8589506)) * SIN(RADIANS(d0_.latitude - 1.0)) + COS(RADIANS(48.8589506)) * COS(RADIANS(d0_.latitude - 1.0)) * COS(RADIANS(d0_.longitude + 1.0) - RADIANS(2.2768489))) * 6371000 AS sclr_0 FROM DummyEntity d0_', $query->getSQL());
    }

}

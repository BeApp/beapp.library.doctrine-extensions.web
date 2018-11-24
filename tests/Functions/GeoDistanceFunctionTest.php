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

    public function testSqlBuild()
    {
        $query = $this->entityManager->createQuery('SELECT GEO_DISTANCE(48.8589506, 2.2768489, 40.6976633,-74.1201068) FROM Beapp\Doctrine\Extension\Entities\DummyEntity d');

        $this->assertEquals('SELECT ACOS(SIN(RADIANS(48.8589506)) * SIN(RADIANS(40.6976633)) + COS(RADIANS(48.8589506)) * COS(RADIANS(40.6976633)) * COS(RADIANS(-74.1201068) - RADIANS(2.2768489))) * 6371000 AS sclr_0 FROM DummyEntity d0_', $query->getSQL());
    }

}

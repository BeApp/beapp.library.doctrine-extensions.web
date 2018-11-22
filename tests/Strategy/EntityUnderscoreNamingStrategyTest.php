<?php

namespace Beapp\Doctrine\Extension\Strategy;

use PHPUnit\Framework\TestCase;

class EntityUnderscoreNamingStrategyTest extends TestCase
{

    public function testClassToTableName()
    {
        $strategy = new EntityUnderscoreNamingStrategy();

        $this->assertEquals('user', $strategy->classToTableName('User'));
        $this->assertEquals('user', $strategy->classToTableName('UserEntity'));
        $this->assertEquals('user_validation', $strategy->classToTableName('UserValidationEntity'));

        $this->assertEquals('user_validation', $strategy->classToTableName('Entity\UserValidationEntity'));
        $this->assertEquals('user_validation', $strategy->classToTableName('App\Entity\UserValidationEntity'));
    }

}

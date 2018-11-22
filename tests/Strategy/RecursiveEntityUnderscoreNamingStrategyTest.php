<?php

namespace Beapp\Doctrine\Extension\Strategy;

use PHPUnit\Framework\TestCase;

class RecursiveEntityUnderscoreNamingStrategyTest extends TestCase
{

    public function testClassToTableName()
    {
        $strategy = new RecursiveEntityUnderscoreNamingStrategy();

        $this->assertEquals('user', $strategy->classToTableName('User'));
        $this->assertEquals('user', $strategy->classToTableName('UserEntity'));
        $this->assertEquals('user_validation', $strategy->classToTableName('UserValidationEntity'));

        $this->assertEquals('user_validation', $strategy->classToTableName('Entity\UserValidationEntity'));
        $this->assertEquals('user_validation', $strategy->classToTableName('App\Entity\UserValidationEntity'));
        $this->assertEquals('subpackage_user_validation', $strategy->classToTableName('App\Entity\Subpackage\UserValidationEntity'));
    }

    public function testClassToTableName_otherPackage()
    {
        $strategy = new RecursiveEntityUnderscoreNamingStrategy('App');

        $this->assertEquals('user', $strategy->classToTableName('User'));
        $this->assertEquals('user', $strategy->classToTableName('UserEntity'));
        $this->assertEquals('user_validation', $strategy->classToTableName('UserValidationEntity'));

        $this->assertEquals('entity_user_validation', $strategy->classToTableName('Entity\UserValidationEntity'));
        $this->assertEquals('entity_user_validation', $strategy->classToTableName('App\Entity\UserValidationEntity'));
        $this->assertEquals('entity_subpackage_user_validation', $strategy->classToTableName('App\Entity\Subpackage\UserValidationEntity'));
    }

}

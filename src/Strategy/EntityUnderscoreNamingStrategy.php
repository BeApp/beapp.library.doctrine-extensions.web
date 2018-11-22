<?php

namespace Beapp\Doctrine\Extension\Strategy;

use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

/**
 * Fork of UnderscoreNamingStrategy, used to automatically remove "_entity" suffix from table names
 */
class EntityUnderscoreNamingStrategy extends UnderscoreNamingStrategy
{

    /**
     * @param string $className
     * @return string
     */
    public function classToTableName($className)
    {
        $simplifiedClassName = preg_replace('/Entity$/', '', $className);
        return parent::classToTableName($simplifiedClassName);
    }

}

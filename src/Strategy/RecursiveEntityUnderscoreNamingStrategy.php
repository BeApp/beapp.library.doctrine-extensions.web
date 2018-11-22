<?php

namespace Beapp\Doctrine\Extension\Strategy;

/**
 * Fork of UnderscoreNamingStrategy, used to automatically :
 *
 * <ul>
 *      <li>prepend subpackage of entity to the table name</li>
 *      <li>remove "_entity" suffix from table names</li>
 * </ul>
 */
class RecursiveEntityUnderscoreNamingStrategy extends EntityUnderscoreNamingStrategy
{

    /** @var string */
    private $packageStop;

    public function __construct($packageStop = 'Entity', $case = CASE_LOWER)
    {
        parent::__construct($case);
        $this->packageStop = $packageStop;
    }

    /**
     * @param string $className
     * @return string
     */
    public function classToTableName($className)
    {
        $namespaceParts = explode('\\', $className);

        $extendedClassName = '';
        while (!empty($namespaceParts) && ($lastNamespaceParts = array_pop($namespaceParts)) != $this->packageStop) {
            $extendedClassName = $lastNamespaceParts . $extendedClassName;
        }

        return parent::classToTableName($extendedClassName);
    }

}

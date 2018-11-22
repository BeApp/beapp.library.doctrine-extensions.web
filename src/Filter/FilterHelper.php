<?php

namespace Beapp\Doctrine\Extension\Filter;

use Doctrine\ORM\EntityManagerInterface;

class FilterHelper
{

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Execute the given call function without the specified filter and re-enable it after execution
     *
     * @param string $filter
     * @param callable $callback
     * @return mixed
     */
    public function withoutFilter(string $filter, callable $callback)
    {
        if (!$this->getFilters()->has($filter)) {
            return $callback($this->entityManager);
        }

        try {
            $this->getFilters()->disable($filter);
            return $callback($this->entityManager);
        } finally {
            $this->getFilters()->enable($filter);
        }
    }

    protected function getFilters()
    {
        return $this->entityManager->getFilters();
    }

}

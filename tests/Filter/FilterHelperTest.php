<?php

namespace Beapp\Doctrine\Extension\Filter;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\FilterCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FilterHelperTest extends TestCase
{

    /** @var MockObject|FilterCollection */
    private $filterCollection;

    /** @var FilterHelper */
    private $filterHelper;

    protected function setUp()
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();

        $this->filterCollection = $this->getMockBuilder(FilterCollection::class)->disableOriginalConstructor()->getMock();
        $this->filterHelper = new MockedFilterHelper($entityManager, $this->filterCollection);
    }

    public function testWithoutFilter_unknownFilter()
    {
        $this->filterCollection->expects($this->once())->method('has')->with('unknown-filter')->willReturn(false);
        $this->filterCollection->expects($this->never())->method('disable');
        $this->filterCollection->expects($this->never())->method('enable');

        $this->assertEquals('ok', $this->filterHelper->withoutFilter('unknown-filter', function () {
            return 'ok';
        }));
    }

    public function testWithoutFilter_callbackException()
    {
        $this->filterCollection->expects($this->once())->method('has')->with('my-filter')->willReturn(true);
        $this->filterCollection->expects($this->once())->method('disable')->with('my-filter');
        $this->filterCollection->expects($this->once())->method('enable')->with('my-filter');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Some exception');

        $this->filterHelper->withoutFilter('my-filter', function () {
            throw new \Exception('Some exception');
        });
    }

    public function testWithoutFilter()
    {
        $this->filterCollection->expects($this->once())->method('has')->with('my-filter')->willReturn(true);
        $this->filterCollection->expects($this->once())->method('disable')->with('my-filter');
        $this->filterCollection->expects($this->once())->method('enable')->with('my-filter');

        $this->assertEquals('ok', $this->filterHelper->withoutFilter('my-filter', function () {
            return 'ok';
        }));
    }

}

class MockedFilterHelper extends FilterHelper
{
    private $filterCollection;

    public function __construct(EntityManagerInterface $entityManager, $filterCollection)
    {
        parent::__construct($entityManager);
        $this->filterCollection = $filterCollection;
    }

    protected function getFilters()
    {
        return $this->filterCollection;
    }
}

;

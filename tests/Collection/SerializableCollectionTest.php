<?php

namespace Beapp\Doctrine\Extension\Collection;

use Beapp\Doctrine\Extension\Collections\SerializableCollection;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class SerializableCollectionTest extends TestCase
{

    public function testSerialize()
    {
        $this->assertEquals("{}", json_encode(new ArrayCollection([1, 2])));

        $this->assertEquals("[]", json_encode(SerializableCollection::from([])));
        $this->assertEquals("[1]", json_encode(SerializableCollection::from([1])));
        $this->assertEquals("[1,2,3]", json_encode(SerializableCollection::from([1, 2, 3])));

        $this->assertEquals("{\"key\":\"value\"}", json_encode(SerializableCollection::from(['key' => 'value'])));

        $this->assertEquals("[{\"key\":\"value\"}]", json_encode(SerializableCollection::from([['key' => 'value']])));
    }

}

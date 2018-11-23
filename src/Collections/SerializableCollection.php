<?php

namespace Beapp\Doctrine\Extension\Collections;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Used as syntactic sugar during serialization to not having to call toArray() everytime
 */
class SerializableCollection extends ArrayCollection implements \JsonSerializable
{

    /**
     * @param array $elements
     * @return SerializableCollection
     */
    public static function from(array $elements = []): SerializableCollection
    {
        return new SerializableCollection($elements);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}

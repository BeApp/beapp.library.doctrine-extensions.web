<?php

namespace Beapp\Doctrine\Extension\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class DummyEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue)
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @ORM\Column(type="string")
     */
    public $description;

    /**
     * @ORM\Column(type="float")
     */
    public $latitude;

    /**
     * @ORM\Column(type="float")
     */
    public $longitude;

}

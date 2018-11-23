<?php

namespace Beapp\Doctrine\Extension\Entity;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

}

<?php

namespace Beapp\Doctrine\Extension\Entity;

use Doctrine\ORM\Mapping as ORM;

trait UuidTrait
{

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    protected $uuid;

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

}

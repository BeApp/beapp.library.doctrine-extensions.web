<?php

namespace Beapp\Doctrine\Extension\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": 1})
     */
    private $active = true;

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}

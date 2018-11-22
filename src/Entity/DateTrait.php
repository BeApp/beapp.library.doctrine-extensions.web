<?php

namespace Beapp\Doctrine\Extension\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Don't forget to add the {@link HasLifecycleCallbacks} annotation on the entity to trigger onPrePersist and onPreUpdate methods
 */
trait DateTrait
{
    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $creationDate;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updateDate;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->creationDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updateDate = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return $this
     */
    public function setCreationDate(\DateTime $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdateDate(): ?\DateTime
    {
        return $this->updateDate;
    }

    /**
     * @param \DateTime $updateDate
     * @return $this
     */
    public function setUpdateDate(\DateTime $updateDate): self
    {
        $this->updateDate = $updateDate;
        return $this;
    }
}

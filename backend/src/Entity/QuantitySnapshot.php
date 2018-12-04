<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Represents a snapshot of a given reward's quantity at a specific point in time.
 *
 * @ORM\Entity(repositoryClass="App\Repository\QuantitySnapshotRepository")
 * @Serializer\ExclusionPolicy("ALL")
 */
class QuantitySnapshot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reward", inversedBy="quantitySnapshots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reward;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     */
    private $quantity;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose()
     */
    private $dateTime;

    /**
     * QuantitySnapshot constructor.
     */
    public function __construct()
    {
        $this->dateTime = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getReward(): ?Reward
    {
        return $this->reward;
    }

    public function setReward(?Reward $reward): self
    {
        $this->reward = $reward;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }
}

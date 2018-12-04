<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RewardRepository")
 * @Serializer\ExclusionPolicy("ALL")
 */
class Reward
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose()
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Expose()
     */
    private $lastKnownQuantity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuantitySnapshot", mappedBy="reward", orphanRemoval=true)
     */
    private $quantitySnapshots;

    public function __construct()
    {
        $this->quantitySnapshots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getLastKnownQuantity(): ?int
    {
        return $this->lastKnownQuantity;
    }

    public function setLastKnownQuantity(?int $lastKnownQuantity): self
    {
        $this->lastKnownQuantity = $lastKnownQuantity;

        return $this;
    }

    /**
     * @return Collection|QuantitySnapshot[]
     */
    public function getQuantitySnapshots(): Collection
    {
        return $this->quantitySnapshots;
    }

    public function addQuantitySnapshot(QuantitySnapshot $quantitySnapshot): self
    {
        if (!$this->quantitySnapshots->contains($quantitySnapshot)) {
            $this->quantitySnapshots[] = $quantitySnapshot;
            $quantitySnapshot->setReward($this);
        }

        return $this;
    }

    public function removeQuantitySnapshot(QuantitySnapshot $quantitySnapshot): self
    {
        if ($this->quantitySnapshots->contains($quantitySnapshot)) {
            $this->quantitySnapshots->removeElement($quantitySnapshot);
            // set the owning side to null (unless already changed)
            if ($quantitySnapshot->getReward() === $this) {
                $quantitySnapshot->setReward(null);
            }
        }

        return $this;
    }
}

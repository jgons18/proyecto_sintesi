<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarrierRepository")
 */
class Carrier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $namecarrier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="carrier")
     */
    private $details;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orderr", mappedBy="carrier")
     */
    private $orderrs;

    public function __construct()
    {
        $this->details = new ArrayCollection();
        $this->orderrs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamecarrier(): ?string
    {
        return $this->namecarrier;
    }

    public function setNamecarrier(string $namecarrier): self
    {
        $this->namecarrier = $namecarrier;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setCarrier($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getCarrier() === $this) {
                $detail->setCarrier(null);
            }
        }

        return $this;
    }
    /**
     * Función para convertir a string el array de los transportistas
     * @return mixed
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->namecarrier;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Orderr[]
     */
    public function getOrderrs(): Collection
    {
        return $this->orderrs;
    }

    public function addOrderr(Orderr $orderr): self
    {
        if (!$this->orderrs->contains($orderr)) {
            $this->orderrs[] = $orderr;
            $orderr->setCarrier($this);
        }

        return $this;
    }

    public function removeOrderr(Orderr $orderr): self
    {
        if ($this->orderrs->contains($orderr)) {
            $this->orderrs->removeElement($orderr);
            // set the owning side to null (unless already changed)
            if ($orderr->getCarrier() === $this) {
                $orderr->setCarrier(null);
            }
        }

        return $this;
    }

}

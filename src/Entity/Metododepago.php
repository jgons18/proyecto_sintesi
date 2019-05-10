<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetododepagoRepository")
 */
class Metododepago
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $nombremetodo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detalle", mappedBy="metododepago")
     */
    private $detalles;

    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombremetodo(): ?string
    {
        return $this->nombremetodo;
    }

    public function setNombremetodo(string $nombremetodo): self
    {
        $this->nombremetodo = $nombremetodo;

        return $this;
    }

    /**
     * @return Collection|Detalle[]
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(Detalle $detalle): self
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles[] = $detalle;
            $detalle->setMetododepago($this);
        }

        return $this;
    }

    public function removeDetalle(Detalle $detalle): self
    {
        if ($this->detalles->contains($detalle)) {
            $this->detalles->removeElement($detalle);
            // set the owning side to null (unless already changed)
            if ($detalle->getMetododepago() === $this) {
                $detalle->setMetododepago(null);
            }
        }

        return $this;
    }
}

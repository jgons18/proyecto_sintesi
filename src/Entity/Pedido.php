<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pedidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pedidoconfirmado;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $direccionprincipal;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $direccionsecundaria;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $nombretitulartarjeta;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $numerotarjeta;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detalle", mappedBy="pedido")
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPedidoconfirmado(): ?bool
    {
        return $this->pedidoconfirmado;
    }

    public function setPedidoconfirmado(bool $pedidoconfirmado): self
    {
        $this->pedidoconfirmado = $pedidoconfirmado;

        return $this;
    }

    public function getDireccionprincipal(): ?string
    {
        return $this->direccionprincipal;
    }

    public function setDireccionprincipal(string $direccionprincipal): self
    {
        $this->direccionprincipal = $direccionprincipal;

        return $this;
    }

    public function getDireccionsecundaria(): ?string
    {
        return $this->direccionsecundaria;
    }

    public function setDireccionsecundaria(?string $direccionsecundaria): self
    {
        $this->direccionsecundaria = $direccionsecundaria;

        return $this;
    }

    public function getNombretitulartarjeta(): ?string
    {
        return $this->nombretitulartarjeta;
    }

    public function setNombretitulartarjeta(?string $nombretitulartarjeta): self
    {
        $this->nombretitulartarjeta = $nombretitulartarjeta;

        return $this;
    }

    public function getNumerotarjeta(): ?string
    {
        return $this->numerotarjeta;
    }

    public function setNumerotarjeta(string $numerotarjeta): self
    {
        $this->numerotarjeta = $numerotarjeta;

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
            $detalle->setPedido($this);
        }

        return $this;
    }

    public function removeDetalle(Detalle $detalle): self
    {
        if ($this->detalles->contains($detalle)) {
            $this->detalles->removeElement($detalle);
            // set the owning side to null (unless already changed)
            if ($detalle->getPedido() === $this) {
                $detalle->setPedido(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nombreproducto;

    /**
     * @ORM\Column(type="float")
     */
    private $preciounidad;

    /**
     * @ORM\Column(type="float")
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     */
    private $stockreservado;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $esfruta;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Temporada", inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $temporada;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detalle", mappedBy="producto")
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

    public function getNombreproducto(): ?string
    {
        return $this->nombreproducto;
    }

    public function setNombreproducto(string $nombreproducto): self
    {
        $this->nombreproducto = $nombreproducto;

        return $this;
    }

    public function getPreciounidad(): ?float
    {
        return $this->preciounidad;
    }

    public function setPreciounidad(float $preciounidad): self
    {
        $this->preciounidad = $preciounidad;

        return $this;
    }

    public function getStock(): ?float
    {
        return $this->stock;
    }

    public function setStock(float $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStockreservado(): ?float
    {
        return $this->stockreservado;
    }

    public function setStockreservado(float $stockreservado): self
    {
        $this->stockreservado = $stockreservado;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEsfruta(): ?bool
    {
        return $this->esfruta;
    }

    public function setEsfruta(bool $esfruta): self
    {
        $this->esfruta = $esfruta;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getTemporada(): ?Temporada
    {
        return $this->temporada;
    }

    public function setTemporada(?Temporada $temporada): self
    {
        $this->temporada = $temporada;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

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
            $detalle->setProducto($this);
        }

        return $this;
    }

    public function removeDetalle(Detalle $detalle): self
    {
        if ($this->detalles->contains($detalle)) {
            $this->detalles->removeElement($detalle);
            // set the owning side to null (unless already changed)
            if ($detalle->getProducto() === $this) {
                $detalle->setProducto(null);
            }
        }

        return $this;
    }
}

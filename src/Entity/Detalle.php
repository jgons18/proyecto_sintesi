<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetalleRepository")
 */
class Detalle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pedido", inversedBy="detalles")
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="detalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transportista", inversedBy="detalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transportista;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Metododepago", inversedBy="detalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $metododepago;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getTransportista(): ?Transportista
    {
        return $this->transportista;
    }

    public function setTransportista(?Transportista $transportista): self
    {
        $this->transportista = $transportista;

        return $this;
    }

    public function getMetododepago(): ?Metododepago
    {
        return $this->metododepago;
    }

    public function setMetododepago(?Metododepago $metododepago): self
    {
        $this->metododepago = $metododepago;

        return $this;
    }
}

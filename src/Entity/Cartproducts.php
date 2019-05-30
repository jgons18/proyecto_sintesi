<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartproductsRepository")
 */
class Cartproducts
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
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $pricetotalpr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="cartproducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cart;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     */
    private $product;

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

    public function getPricetotalpr(): ?float
    {
        return $this->pricetotalpr;
    }

    public function setPricetotalpr(float $pricetotalpr): self
    {
        $this->pricetotalpr = $pricetotalpr;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="totalprice", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $totalprice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartproducts", mappedBy="cart")
     */
    private $cartproducts;

    public function __construct()
    {
        $this->cartproducts = new ArrayCollection();
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

    public function getTotalprice(): ?float
    {
        return $this->totalprice;
    }

    public function setTotalprice(float $totalprice): self
    {
        $this->totalprice = $totalprice;

        return $this;
    }

    /**
     * @return Collection|Cartproducts[]
     */
    public function getCartproducts(): Collection
    {
        return $this->cartproducts;
    }

    public function addCartproduct(Cartproducts $cartproduct): self
    {
        if (!$this->cartproducts->contains($cartproduct)) {
            $this->cartproducts[] = $cartproduct;
            $cartproduct->setCart($this);
        }

        return $this;
    }

    public function removeCartproduct(Cartproducts $cartproduct): self
    {
        if ($this->cartproducts->contains($cartproduct)) {
            $this->cartproducts->removeElement($cartproduct);
            // set the owning side to null (unless already changed)
            if ($cartproduct->getCart() === $this) {
                $cartproduct->setCart(null);
            }
        }

        return $this;
    }
}

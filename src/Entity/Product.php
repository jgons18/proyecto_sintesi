<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Offer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
    private $nameproduct;

    /**
     * @ORM\Column(type="float")
     */
    private $unitprice;

    /**
     * @ORM\Column(type="float")
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     */
    private $reservedstocks;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isfruit;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\NotBlank(message="Please, upload the user avatar as a PNG file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="product")
     */

    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="products")
     */
    private $offer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isoffer;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $offerprice;



    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameproduct(): ?string
    {
        return $this->nameproduct;
    }

    public function setNameproduct(string $nameproduct): self
    {
        $this->nameproduct = $nameproduct;

        return $this;
    }

    public function getUnitprice(): ?float
    {
        return $this->unitprice;
    }

    public function setUnitprice(float $unitprice): self
    {
        $this->unitprice = $unitprice;

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

    public function getReservedstocks(): ?float
    {
        return $this->reservedstocks;
    }

    public function setReservedstocks(float $reservedstocks): self
    {
        $this->reservedstocks = $reservedstocks;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsfruit(): ?bool
    {
        return $this->isfruit;
    }

    public function setIsfruit(bool $isfruit): self
    {
        $this->isfruit = $isfruit;

        return $this;
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

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $detail->setProduct($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getProduct() === $this) {
                $detail->setProduct(null);
            }
        }

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getIsoffer(): ?int
    {
        return $this->isoffer;
    }

    public function setIsoffer(?int $isoffer): self
    {
        $this->isoffer = $isoffer;

        return $this;
    }

    public function getOfferprice(): ?float
    {

        return $this->offerprice;
    }

    /* Clase general
   public function setOfferprice(?float $offerprice): self
    {
        $this->offerprice = $offerprice;

        return $this;
    }
  */
    public function setOfferprice(?float $offerprice): self
    {
        $this->offerprice = $offerprice;

        return $this;
    }

    public function calcular_porcentaje(){
        $por = 100;

    }

    /**
     * Función para convertir a string el array de los productos para poder mostrar el cotenido
     * @return mixed
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nameproduct;
    }


}

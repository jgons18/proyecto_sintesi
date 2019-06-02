<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentmethodRepository")
 */
class Paymentmethod
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
    private $namemethod;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="paymentmethod")
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orderr", mappedBy="paymentmethod")
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

    public function getNamemethod(): ?string
    {
        return $this->namemethod;
    }

    public function setNamemethod(string $namemethod): self
    {
        $this->namemethod = $namemethod;

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
            $detail->setPaymentmethod($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getPaymentmethod() === $this) {
                $detail->setPaymentmethod(null);
            }
        }

        return $this;
    }
    /**
     * Función para convertir a string el array de métodos de pago para poder mostrar su contenido
     * @return mixed
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->namemethod;
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
            $orderr->setPaymentmethod($this);
        }

        return $this;
    }

    public function removeOrderr(Orderr $orderr): self
    {
        if ($this->orderrs->contains($orderr)) {
            $this->orderrs->removeElement($orderr);
            // set the owning side to null (unless already changed)
            if ($orderr->getPaymentmethod() === $this) {
                $orderr->setPaymentmethod(null);
            }
        }

        return $this;
    }
}

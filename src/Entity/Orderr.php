<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderrRepository")
 */
class Orderr
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateeorderr;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paymentconfirmed;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $mainaddress;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $secondarydirection;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nameofowner;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $cardnumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orderrs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="forder")
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Carrier", inversedBy="orderrs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carrier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Paymentmethod", inversedBy="orderrs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentmethod;

    public function __construct()
    {
        $this->details = new ArrayCollection();
        $this->dateeorderr = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateeorderr(): ?\DateTimeInterface
    {
        return $this->dateeorderr;
    }

    public function setDateeorderr(\DateTimeInterface $dateeorderr): self
    {
        $this->dateeorderr = $dateeorderr;

        return $this;
    }

    public function getPaymentconfirmed(): ?bool
    {
        return $this->paymentconfirmed;
    }

    public function setPaymentconfirmed(bool $paymentconfirmed): self
    {
        $this->paymentconfirmed = $paymentconfirmed;

        return $this;
    }

    public function getMainaddress(): ?string
    {
        return $this->mainaddress;
    }

    public function setMainaddress(string $mainaddress): self
    {
        $this->mainaddress = $mainaddress;

        return $this;
    }

    public function getSecondarydirection(): ?string
    {
        return $this->secondarydirection;
    }

    public function setSecondarydirection(?string $secondarydirection): self
    {
        $this->secondarydirection = $secondarydirection;

        return $this;
    }

    public function getNameofowner(): ?string
    {
        return $this->nameofowner;
    }

    public function setNameofowner(string $nameofowner): self
    {
        $this->nameofowner = $nameofowner;

        return $this;
    }

    public function getCardnumber(): ?string
    {
        return $this->cardnumber;
    }

    public function setCardnumber(string $cardnumber): self
    {
        $this->cardnumber = $cardnumber;

        return $this;
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
            $detail->setForder($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getForder() === $this) {
                $detail->setForder(null);
            }
        }

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): self
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getPaymentmethod(): ?Paymentmethod
    {
        return $this->paymentmethod;
    }

    public function setPaymentmethod(?Paymentmethod $paymentmethod): self
    {
        $this->paymentmethod = $paymentmethod;

        return $this;
    }



}

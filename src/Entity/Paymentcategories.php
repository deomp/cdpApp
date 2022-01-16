<?php

namespace App\Entity;

use App\Repository\PaymentcategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentcategoriesRepository::class)]
class Paymentcategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $catname;

    #[ORM\OneToMany(mappedBy: 'paymentcategories', targetEntity: Paymentmodes::class)]
    private $paymentmodes;

    public function __construct()
    {
        $this->paymentmodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatname(): ?string
    {
        return $this->catname;
    }

    public function setCatname(string $catname): self
    {
        $this->catname = $catname;

        return $this;
    }

    /**
     * @return Collection|Paymentmodes[]
     */
    public function getPaymentmodes(): Collection
    {
        return $this->paymentmodes;
    }

    public function addPaymentmode(Paymentmodes $paymentmode): self
    {
        if (!$this->paymentmodes->contains($paymentmode)) {
            $this->paymentmodes[] = $paymentmode;
            $paymentmode->setPaymentcategories($this);
        }

        return $this;
    }

    public function removePaymentmode(Paymentmodes $paymentmode): self
    {
        if ($this->paymentmodes->removeElement($paymentmode)) {
            // set the owning side to null (unless already changed)
            if ($paymentmode->getPaymentcategories() === $this) {
                $paymentmode->setPaymentcategories(null);
            }
        }

        return $this;
    }
}

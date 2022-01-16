<?php

namespace App\Entity;

use App\Repository\PaymentmodesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentmodesRepository::class)]
class Paymentmodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Paymentcategories::class, inversedBy: 'paymentmodes')]
    private $paymentcategories;

    #[ORM\OneToMany(mappedBy: 'paymentmodes', targetEntity: Contributions::class)]
    private $contributions;

    public function __construct()
    {
        $this->contributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPaymentcategories(): ?Paymentcategories
    {
        return $this->paymentcategories;
    }

    public function setPaymentcategories(?Paymentcategories $paymentcategories): self
    {
        $this->paymentcategories = $paymentcategories;

        return $this;
    }

    /**
     * @return Collection|Contributions[]
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contributions $contribution): self
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions[] = $contribution;
            $contribution->setPaymentmodes($this);
        }

        return $this;
    }

    public function removeContribution(Contributions $contribution): self
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getPaymentmodes() === $this) {
                $contribution->setPaymentmodes(null);
            }
        }

        return $this;
    }
}

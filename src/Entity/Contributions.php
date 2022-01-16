<?php

namespace App\Entity;

use App\Repository\ContributionsRepository;
use App\Entity\Categoryfinances;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContributionsRepository::class)]
class Contributions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $tid;

    /**
     * @Assert\GreaterThanOrEqual(50)
     * @Assert\LessThanOrEqual(500)
     */
    #[ORM\Column(type: 'string', length: 10)]
    private $amount;

    #[ORM\Column(type: 'string', length: 50)]
    private $period;

    #[ORM\Column(type: 'string', length: 50)]
    private $status;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $validated_at;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $validatedby;

     /**
     * @Assert\NotEqualTo("0",
     * message="Merci de selectionner un mode de paIement.")
     */
    #[ORM\Column(type: 'string', length: 50)]
    private $paymentmode;

    #[ORM\Column(type: 'string', length: 255)]
    private $proof;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'contributions')]
    private $Users;

   
    #[ORM\Column(type: 'string', length: 10)]
    private $createdby;

    #[ORM\Column(type: 'string', length: 10)]
    private $createdmonth;

    #[ORM\Column(type: 'string', length: 10)]
    private $createdyear;

    #[ORM\Column(type: 'string', length: 10)]
    private $catfinance;

    #[ORM\Column(type: 'string', length: 10)]
    private $paidforhowmanymonth;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTid(): ?string
    {
        return $this->tid;
    }

    public function setTid(string $tid): self
    {
        $this->tid = $tid;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(string $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validated_at;
    }

    public function setValidatedAt(\DateTimeInterface $validated_at): self
    {
        $this->validated_at = $validated_at;

        return $this;
    }

    public function getValidatedby(): ?string
    {
        return $this->validatedby;
    }

    public function setValidatedby(?string $validatedby): self
    {
        $this->validatedby = $validatedby;

        return $this;
    }

    public function getPaymentmode(): ?string
    {
        return $this->paymentmode;
    }

    public function setPaymentmode(?string $paymentmode): self
    {
        $this->paymentmode = $paymentmode;

        return $this;
    }

    public function getProof(): ?string
    {
        return $this->proof;
    }

    public function setProof(string $proof): self
    {
        $this->proof = $proof;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->Users;
    }

    public function setUsers(?Users $Users): self
    {
        $this->Users = $Users;

        return $this;
    }

    
    public function getCreatedby(): ?string
    {
        return $this->createdby;
    }

    public function setCreatedby(string $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    
    public function getCreatedmonth(): ?string
    {
        return $this->createdmonth;
    }

    public function setCreatedmonth(string $createdmonth): self
    {
        $this->createdmonth = $createdmonth;

        return $this;
    }

    public function getCreatedyear(): ?string
    {
        return $this->createdyear;
    }

    public function setCreatedyear(string $createdyear): self
    {
        $this->createdyear = $createdyear;

        return $this;
    }

    public function getCatfinance(): ?string
    {
        return $this->catfinance;
    }

    public function setCatfinance(string $catfinance): self
    {
        $this->catfinance = $catfinance;

        return $this;
    }

    public function getPaidforhowmanymonth(): ?string
    {
        return $this->paidforhowmanymonth;
    }

    public function setPaidforhowmanymonth(string $paidforhowmanymonth): self
    {
        $this->paidforhowmanymonth = $paidforhowmanymonth;

        return $this;
    }

    

    
}

<?php

namespace App\Entity;

use App\Repository\AlertRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AlertRepository::class)]
class Alert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getAlerts'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    #[Groups(['getAlerts'])]
    private ?float $min = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    #[Groups(['getAlerts'])]
    private ?float $max = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 50)]
    #[Groups(['getAlerts'])]
    private ?string $deviseBase = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 10)]
    #[Groups(['getAlerts'])]
    private ?string $idBase = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 50)]
    #[Groups(['getAlerts'])]
    private ?string $deviseDiv = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 10)]
    #[Groups(['getAlerts'])]
    private ?string $idDiv = null;

    #[ORM\ManyToOne(inversedBy: 'Alerts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // * Constructor:
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function setMin(?float $min): static
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function setMax(?float $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeviseBase(): ?string
    {
        return $this->deviseBase;
    }

    public function setDeviseBase(string $deviseBase): static
    {
        $this->deviseBase = $deviseBase;

        return $this;
    }

    public function getIdBase(): ?string
    {
        return $this->idBase;
    }

    public function setIdBase(string $idBase): static
    {
        $this->idBase = $idBase;

        return $this;
    }

    public function getDeviseDiv(): ?string
    {
        return $this->deviseDiv;
    }

    public function setDeviseDiv(string $deviseDiv): static
    {
        $this->deviseDiv = $deviseDiv;

        return $this;
    }

    public function getIdDiv(): ?string
    {
        return $this->idDiv;
    }

    public function setIdDiv(string $idDiv): static
    {
        $this->idDiv = $idDiv;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

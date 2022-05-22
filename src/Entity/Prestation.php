<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255,  nullable: true)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $currentKilometre;

    #[ORM\Column(type: 'integer')]
    private $nextKilometre;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $nextDate;

    #[ORM\ManyToOne(targetEntity: Vehicule::class, inversedBy: 'prestation')]
    private $vehicule;

    #[ORM\Column(type: 'boolean')]
    private $payed;

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

    public function getCurrentKilometre(): ?int
    {
        return $this->currentKilometre;
    }

    public function setCurrentKilometre(int $currentKilometre): self
    {
        $this->currentKilometre = $currentKilometre;

        return $this;
    }

    public function getNextKilometre(): ?int
    {
        return $this->nextKilometre;
    }

    public function setNextKilometre(int $nextKilometre): self
    {
        $this->nextKilometre = $nextKilometre;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNextDate(): ?\DateTimeInterface
    {
        return $this->nextDate;
    }

    public function setNextDate(?\DateTimeInterface $nextDate): self
    {
        $this->nextDate = $nextDate;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getPayed(): ?bool
    {
        return $this->payed;
    }

    public function setPayed(bool $payed): self
    {
        $this->payed = $payed;

        return $this;
    }
}

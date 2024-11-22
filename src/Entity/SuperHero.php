<?php

namespace App\Entity;

use App\Repository\SuperHeroRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuperHeroRepository::class)]
class SuperHero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alterEgo = null;

    #[ORM\Column]
    private ?bool $estDisponible = null;

    #[ORM\Column(type: "integer", options: ["unsigned" => true])]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: "L'énergie doit être comprise entre {{ min }} et {{ max }}.")]
    private ?int $energieLevel = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $biographie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageNom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'leader')]
    private Collection $teams;

    /**
     * @var Collection<int, Pouvoir>
     */
    #[ORM\ManyToMany(targetEntity: Pouvoir::class, inversedBy: 'superHeroes')]
    private Collection $pouvoirs;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->pouvoirs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAlterEgo(): ?string
    {
        return $this->alterEgo;
    }

    public function setAlterEgo(?string $alterEgo): static
    {
        $this->alterEgo = $alterEgo;

        return $this;
    }

    public function isEstDisponible(): ?bool
    {
        return $this->estDisponible;
    }

    public function setEstDisponible(bool $estDisponible): static
    {
        $this->estDisponible = $estDisponible;

        return $this;
    }

    public function getEnergieLevel(): ?int
    {
        return $this->energieLevel;
    }

    public function setEnergieLevel(int $energieLevel): static
    {
        $this->energieLevel = $energieLevel;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(string $biographie): static
    {
        $this->biographie = $biographie;

        return $this;
    }

    public function getImageNom(): ?string
    {
        return $this->imageNom;
    }

    public function setImageNom(?string $imageNom): static
    {
        $this->imageNom = $imageNom;

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

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setLeader($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getLeader() === $this) {
                $team->setLeader(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pouvoir>
     */
    public function getPouvoirs(): Collection
    {
        return $this->pouvoirs;
    }

    public function addPouvoir(Pouvoir $pouvoir): static
    {
        if (!$this->pouvoirs->contains($pouvoir)) {
            $this->pouvoirs->add($pouvoir);
        }

        return $this;
    }

    public function removePouvoir(Pouvoir $pouvoir): static
    {
        $this->pouvoirs->removeElement($pouvoir);

        return $this;
    }
}

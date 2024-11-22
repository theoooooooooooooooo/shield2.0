<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'équipe est obligatoire.")]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $estActive = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Un leader est requis pour l'équipe.")]
    private ?SuperHero $leader = null;

    /**
     * @var Collection<int, SuperHero>
     */
    #[ORM\ManyToMany(targetEntity: SuperHero::class, inversedBy: 'teams')]
    #[Assert\Count(
        min: 2,
        max: 5,
        minMessage: "Une équipe doit avoir au moins {{ limit }} membres.",
        maxMessage: "Une équipe ne peut pas avoir plus de {{ limit }} membres."
    )]
    private Collection $members;

    #[ORM\OneToOne(inversedBy: 'team', cascade: ['persist', 'remove'])]
    private ?Mission $currentMission = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function isEstActive(): ?bool
    {
        return $this->estActive;
    }

    public function setEstActive(bool $estActive): static
    {
        $this->estActive = $estActive;

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

    public function getLeader(): ?SuperHero
    {
        return $this->leader;
    }

    public function setLeader(?SuperHero $leader): static
    {
        // Vérifie si le leader a un niveau d'énergie > 80
        if ($leader && $leader->getEnergieLevel() <= 80) {
            throw new \LogicException("Le leader doit avoir un niveau d'énergie supérieur à 80.");
        }

        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Collection<int, SuperHero>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(SuperHero $member): static
    {
        // Vérifie si le membre est déjà dans une autre équipe
        if ($member->getTeams()->count() > 0) {
            throw new \LogicException("Un super-héros ne peut appartenir qu'à une seule équipe.");
        }

        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(SuperHero $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }

    public function getCurrentMission(): ?Mission
    {
        return $this->currentMission;
    }

    public function setCurrentMission(?Mission $currentMission): static
    {
        $this->currentMission = $currentMission;

        return $this;
    }
}

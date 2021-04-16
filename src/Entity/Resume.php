<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Carbon\Carbon;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResumeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Resume
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="resumes")
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $statement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Experience::class, mappedBy="resume")
     */
    private $experiences;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="resumes")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Qualification::class, mappedBy="resume")
     */
    private $qualifications;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearsExperience;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Pair::class, mappedBy="resume")
     */
    private $pairs;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->experiences = new ArrayCollection();
        $this->qualifications = new ArrayCollection();
        $this->pairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

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

    public function getStatement(): ?string
    {
        return $this->statement;
    }

    public function setStatement(?string $statement): self
    {
        $this->statement = $statement;

        return $this;
    }

    public function getCreateAtForHumans()
    {
        $date = Carbon::parse($this->createdAt);
        return $date->diffForHumans();
    }

    public function getUpdatedAtForHumans()
    {
        $date = Carbon::parse($this->updatedAt);
        return $date->diffForHumans();
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Experience[]
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setResume($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getResume() === $this) {
                $experience->setResume(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Qualification[]
     */
    public function getQualifications(): Collection
    {
        return $this->qualifications;
    }

    public function addQualification(Qualification $qualification): self
    {
        if (!$this->qualifications->contains($qualification)) {
            $this->qualifications[] = $qualification;
            $qualification->setResume($this);
        }

        return $this;
    }

    public function removeQualification(Qualification $qualification): self
    {
        if ($this->qualifications->removeElement($qualification)) {
            // set the owning side to null (unless already changed)
            if ($qualification->getResume() === $this) {
                $qualification->setResume(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setPrePersistUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getYearsExperience(): ?int
    {
        return $this->yearsExperience;
    }

    public function setYearsExperience(?int $yearsExperience): self
    {
        $this->yearsExperience = $yearsExperience;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Pair[]
     */
    public function getPairs(): Collection
    {
        return $this->pairs;
    }

    public function addPair(Pair $pair): self
    {
        if (!$this->pairs->contains($pair)) {
            $this->pairs[] = $pair;
            $pair->setResume($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): self
    {
        if ($this->pairs->removeElement($pair)) {
            // set the owning side to null (unless already changed)
            if ($pair->getResume() === $this) {
                $pair->setResume(null);
            }
        }

        return $this;
    }
}

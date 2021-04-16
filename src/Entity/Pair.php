<?php

namespace App\Entity;

use App\Repository\PairRepository;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PairRepository::class)
 */
class Pair
{

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pairs")
     */
    private $candidate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPositionLiked;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCandidateLiked;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Vacancy::class, inversedBy="pairs")
     */
    private $vacancy;

    /**
     * @ORM\ManyToOne(targetEntity=Resume::class, inversedBy="pairs")
     */
    private $resume;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?User
    {
        return $this->candidate;
    }

    public function setCandidate(?User $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getIsPositionLiked(): ?bool
    {
        return $this->isPositionLiked;
    }

    public function setIsPositionLiked(bool $isPositionLiked): self
    {
        $this->isPositionLiked = $isPositionLiked;

        return $this;
    }

    public function getIsCandidateLiked(): ?bool
    {
        return $this->isCandidateLiked;
    }

    public function setIsCandidateLiked(bool $isCandidateLiked): self
    {
        $this->isCandidateLiked = $isCandidateLiked;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedAtForHumans(): string
    {
        $date = Carbon::parse($this->createdAt);
        return $date->diffForHumans();
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVacancy(): ?Vacancy
    {
        return $this->vacancy;
    }

    public function setVacancy(?Vacancy $vacancy): self
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        $this->resume = $resume;

        return $this;
    }
}

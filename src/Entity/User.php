<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */


class User implements UserInterface
{

    const ROLE_EMPLOYER = 'ROLE_EMPLOYER';
    const ROLE_EMPLOYEE = 'ROLE_EMPLOYEE';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Resume::class, mappedBy="owner")
     */
    private $resumes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity=Pair::class, mappedBy="candidate")
     */
    private $pairs;

    /**
     * @ORM\OneToMany(targetEntity=Vacancy::class, mappedBy="owner")
     */
    private $getAuthouredVacancies;

    public function __construct()
    {
        $this->resumes = new ArrayCollection();
        $this->pairs = new ArrayCollection();
        $this->getAuthouredVacancies = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function getAccountType(): string
    {
        $roles = $this->roles;
        foreach ($roles as $role) {
            return match ($role) {
                self::ROLE_EMPLOYER => self::ROLE_EMPLOYER,
                self::ROLE_EMPLOYEE => self::ROLE_EMPLOYEE
            };
        }
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }


    /**
     * @return Collection|Resume[]
     */
    public function getResumes(): Collection
    {
        return $this->resumes;
    }

    public function addResume(Resume $resume): self
    {
        if (!$this->resumes->contains($resume)) {
            $this->resumes[] = $resume;
            $resume->setOwner($this);
        }

        return $this;
    }

    public function removeResume(Resume $resume): self
    {
        if ($this->resumes->removeElement($resume)) {
            // set the owning side to null (unless already changed)
            if ($resume->getOwner() === $this) {
                $resume->setOwner(null);
            }
        }

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
            $pair->setCandidate($this);
        }

        return $this;
    }

    public function removePair(Pair $pair): self
    {
        if ($this->pairs->removeElement($pair)) {
            // set the owning side to null (unless already changed)
            if ($pair->getCandidate() === $this) {
                $pair->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vacancy[]
     */
    public function getGetAuthouredVacancies(): Collection
    {
        return $this->getAuthouredVacancies;
    }

    public function addGetAuthouredVacancy(Vacancy $getAuthouredVacancy): self
    {
        if (!$this->getAuthouredVacancies->contains($getAuthouredVacancy)) {
            $this->getAuthouredVacancies[] = $getAuthouredVacancy;
            $getAuthouredVacancy->setOwner($this);
        }

        return $this;
    }

    public function removeGetAuthouredVacancy(Vacancy $getAuthouredVacancy): self
    {
        if ($this->getAuthouredVacancies->removeElement($getAuthouredVacancy)) {
            // set the owning side to null (unless already changed)
            if ($getAuthouredVacancy->getOwner() === $this) {
                $getAuthouredVacancy->setOwner(null);
            }
        }

        return $this;
    }
}

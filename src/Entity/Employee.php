<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Validator\Constraints as Assert;


enum Gender: string
{
    case Homme = 'M';
    case Femme = "F";
    case Non_Binary = 'X';
}


#[ORM\Table('employees')]
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'emp_no')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 14)]
    #[Assert\Length(min: 3, max: 14)]
    private ?string $firstName = null;

    #[ORM\Column(length: 16)]
    #[Assert\Length(min: 3, max: 16)]
    private ?string $lastName = null;

    #[ORM\Column(length: 1, type: 'string', enumType: Gender::class)]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $hireDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Demand::class)]
    private Collection $demands;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getHireDate(): ?\DateTimeInterface
    {
        return $this->hireDate;
    }

    public function setHireDate(\DateTimeInterface $hireDate): static
    {
        $this->hireDate = $hireDate;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function __toString(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * @return Collection<int, Demand>
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }

    public function addDemand(Demand $demand): static
    {
        if (!$this->demands->contains($demand)) {
            $this->demands->add($demand);
            $demand->setEmploye($this);
        }

        return $this;
    }

    public function removeDemand(Demand $demand): static
    {
        if ($this->demands->removeElement($demand)) {
            // set the owning side to null (unless already changed)
            if ($demand->getEmploye() === $this) {
                $demand->setEmploye(null);
            }
        }

        return $this;
    }
}

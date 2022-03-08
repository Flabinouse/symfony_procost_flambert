<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @ORM\Table(name="employee")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var Profession
     * 
     * @ORM\ManyToOne(targetEntity=Profession::class, inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profession;

    /**
     * @var float
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    /**
     * @ORM\Column(type="float")
     */
    private $dailyCost;

    /**
     * @var \DateTime
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    /**
     * @ORM\Column(type="date")
     */
    private $hireDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    public function setProfession(Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDailyCost(): ?float
    {
        return $this->dailyCost;
    }

    public function setDailyCost(float $dailyCost): self
    {
        $this->dailyCost = $dailyCost;

        return $this;
    }

    public function getHireDate(): ?\DateTimeInterface
    {
        return $this->hireDate;
    }

    public function setHireDate(\DateTimeInterface $hireDate): self
    {
        $this->hireDate = $hireDate;

        return $this;
    }
}
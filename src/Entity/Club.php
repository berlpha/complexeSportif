<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClubRepository")
 */
class Club
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hall", mappedBy="club")
     */
    private $hall;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Field", mappedBy="club")
     */
    private $field;

    public function __construct()
    {
        $this->hall = new ArrayCollection();
        $this->field = new ArrayCollection();
    }

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

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Hall[]
     */
    public function getHall(): Collection
    {
        return $this->hall;
    }

    public function addHall(Hall $hall): self
    {
        if (!$this->hall->contains($hall)) {
            $this->hall[] = $hall;
            $hall->setClub($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): self
    {
        if ($this->hall->contains($hall)) {
            $this->hall->removeElement($hall);
            // set the owning side to null (unless already changed)
            if ($hall->getClub() === $this) {
                $hall->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Field[]
     */
    public function getField(): Collection
    {
        return $this->field;
    }

    public function addField(Field $field): self
    {
        if (!$this->field->contains($field)) {
            $this->field[] = $field;
            $field->setClub($this);
        }

        return $this;
    }

    public function removeField(Field $field): self
    {
        if ($this->field->contains($field)) {
            $this->field->removeElement($field);
            // set the owning side to null (unless already changed)
            if ($field->getClub() === $this) {
                $field->setClub(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}

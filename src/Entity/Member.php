<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Nursery", inversedBy="member")
     */
    private $nursery;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subscription", inversedBy="member")
     */
    private $subscription;

    /**
     * @ORM\ManyToMany(targetEntity=Booking::class, mappedBy="Member")
     */
    private $bookings;

    public function __construct()
    {
        parent::__construct();
        $this->nursery = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    /*public function getId(): ?int
    {
        return $this->id;
    }*/

    /**
     * @return Collection|Nursery[]
     */
    public function getNursery(): Collection
    {
        return $this->nursery;
    }

    public function addNursery(Nursery $nursery): self
    {
        if (!$this->nursery->contains($nursery)) {
            $this->nursery[] = $nursery;
        }

        return $this;
    }

    public function removeNursery(Nursery $nursery): self
    {
        if ($this->nursery->contains($nursery)) {
            $this->nursery->removeElement($nursery);
        }

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->addMember($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            $booking->removeMember($this);
        }

        return $this;
    }
}

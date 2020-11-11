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
    //private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Nursery", inversedBy="members")
     */
    private $nurseries;

    /**
     * @ORM\ManyToMany(targetEntity=Booking::class, mappedBy="members")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="member")
     */
    private $subscriptions;

    public function __construct()
    {
        parent::__construct();
        $this->nurseries = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->nurseries = new ArrayCollection();
    }

//    public function getId(): ?int
//    {
//        return $this->id;
//    }

    /**
     * @return Collection|Nursery[]
     */
    public function getNursery(): Collection
    {
        return $this->nurseries;
    }

    public function addNursery(Nursery $nursery): self
    {
        if (!$this->nurseries->contains($nursery)) {
            $this->nurseries[] = $nursery;
        }

        return $this;
    }

    public function removeNursery(Nursery $nursery): self
    {
        if ($this->nurseries->contains($nursery)) {
            $this->nurseries->removeElement($nursery);
        }

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

    public function getUsername(): ?string
    {
        return parent::getUsername();
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setMember($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->contains($subscription)) {
            $this->subscriptions->removeElement($subscription);
            // set the owning side to null (unless already changed)
            if ($subscription->getMember() === $this) {
                $subscription->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Nursery[]
     */
    public function getNurseries(): Collection
    {
        return $this->nurseries;
    }

    public function addNurseries(Nursery $nurseries): self
    {
        if (!$this->nurseries->contains($nurseries)) {
            $this->nurseries[] = $nurseries;
        }

        return $this;
    }

    public function removeNurseries(Nursery $nurseries): self
    {
        $this->nurseries->removeElement($nurseries);

        return $this;
    }
}

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
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="member")
     */
    private $participation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Nursery", inversedBy="member")
     */
    private $nursery;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subscription", inversedBy="member")
     */
    private $subscription;

    public function __construct()
    {
        parent::__construct();
        $this->participation = new ArrayCollection();
        $this->nursery = new ArrayCollection();
    }

    /*public function getId(): ?int
    {
        return $this->id;
    }*/

    /**
     * @return Collection|Participation[]
     */
    public function getParticipation(): Collection
    {
        return $this->participation;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participation->contains($participation)) {
            $this->participation[] = $participation;
            $participation->setMember($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participation->contains($participation)) {
            $this->participation->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getMember() === $this) {
                $participation->setMember(null);
            }
        }

        return $this;
    }

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
}

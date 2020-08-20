<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $participate = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateParticipate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="participation")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="participation")
     */
    private $lesson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipate(): ?bool
    {
        if ($this->participate == true)
        {
            $this->dateParticipate = new \DateTime('now');
        }
        return $this->participate;
    }

    public function setParticipate(bool $participate): self
    {
        $this->participate = $participate;

        return $this;
    }

    public function getDateParticipate(): ?\DateTimeInterface
    {
        return $this->dateParticipate;
    }

//    public function setDateParticipate(\DateTimeInterface $dateParticipate): self
//    {
//        $this->dateParticipate = $dateParticipate;
//
//        return $this;
//    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }
}

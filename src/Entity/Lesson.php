<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonRepository")
 * @Vich\Uploadable
 */
class Lesson
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     *  @var string|null
     */
    private $urlPicture;

    /**
     * @Vich\UploadableField(mapping="lesson_images", fileNameProperty="urlPicture")
     *
     * @var File|null
     */
    private $pictureFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="lesson")
     */
    private $participation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subscription", mappedBy="lessons")
     */
    private $subscriptions;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Coach", inversedBy="lessons")
     */
    private $coach;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Booking", mappedBy="lesson")
     */
    private $bookings;

    public function __construct()
    {
        $this->participation = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->coach = new ArrayCollection();
        $this->updatedAt = new \DateTime('now');
        $this->bookings = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUrlPicture(): ?string
    {
        return $this->urlPicture;
    }

    public function setUrlPicture(string $urlPicture): self
    {
        $this->urlPicture = $urlPicture;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $pictureFile
     */
    public function setPictureFile(File $pictureFile)
    {
        $this->pictureFile = $pictureFile;

        if ($this->pictureFile instanceof UploadedFile)
        {
            $this->updatedAt = new \DateTime('now');
        }
        return $this->pictureFile;
    }

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
            $participation->setLesson($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participation->contains($participation)) {
            $this->participation->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getLesson() === $this) {
                $participation->setLesson(null);
            }
        }

        return $this;
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
            $subscription->addLesson($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->contains($subscription)) {
            $this->subscriptions->removeElement($subscription);
            $subscription->removeLesson($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection|Coach[]
     */
    public function getCoach(): Collection
    {
        return $this->coach;
    }

    public function addCoach(Coach $coach): self
    {
        if (!$this->coach->contains($coach)) {
            $this->coach[] = $coach;
        }

        return $this;
    }

    public function removeCoach(Coach $coach): self
    {
        if ($this->coach->contains($coach)) {
            $this->coach->removeElement($coach);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
            $booking->addLesson($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            $booking->removeLesson($this);
        }

        return $this;
    }
}

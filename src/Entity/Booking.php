<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $priceTotal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hall", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=True)
     */
    private $hall;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Field", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=true)
     */
    private $field;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Lesson", inversedBy="bookings")
     */
    private $lesson;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Member::class, inversedBy="bookings")
     */
    private $Member;

    public function __construct()
    {
        $this->lesson = new ArrayCollection();
        $this->Member = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPriceTotal(): ?float
    {
        return $this->priceTotal;
    }

    public function setPriceTotal(float $priceTotal): self
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function getLesson(): Collection
    {
        return $this->lesson;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lesson->contains($lesson)) {
            $this->lesson[] = $lesson;
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lesson->contains($lesson)) {
            $this->lesson->removeElement($lesson);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
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

    /**
     * @return Collection|Member[]
     */
    public function getMember(): Collection
    {
        return $this->Member;
    }

    public function addMember(Member $member): self
    {
        if (!$this->Member->contains($member)) {
            $this->Member[] = $member;
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->Member->contains($member)) {
            $this->Member->removeElement($member);
        }

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validateSpecialField(ExecutionContextInterface $context){

        if($this->getHall()==null and $this->getField()==null){
            $context
                ->BuildViolation("Terrain et salle ne peuvent pas être vide en même temps")
                ->atPath("hall")
                ->addViolation();
            $context
                ->BuildViolation("Terrain et salle ne peuvent pas être vide en même temps")
                ->atPath("field")
                ->addViolation();
        }

        if($this->getHall()!=null and $this->getField()!=null){
            $context
                ->BuildViolation("Terrain et salle ne peuvent pas être rempli en même temps")
                ->atPath("hall")
                ->addViolation();
            $context
                ->BuildViolation("Terrain et salle ne peuvent pas être rempli en même temps")
                ->atPath("field")
                ->addViolation();
        }

        if($this->getType() == 'Externe' and $this->getPriceTotal() == null ){
            $context
                ->BuildViolation("La réservation externe est payante")
                ->atPath("priceTotal")
                ->addViolation();
        }

        if($this->getType() == 'Interne' and $this->getPriceTotal() != null ){
            $context
                ->BuildViolation("La réservation interne n'est pas payante")
                ->atPath("priceTotal")
                ->addViolation();
        }
    }
}

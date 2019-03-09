<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendRepository")
 */
class Friend
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $action;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", inversedBy="friends")
     */
    private $member_1;

    private $member_2;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->member_1 = new ArrayCollection();
        $this->member_2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?int
    {
        return $this->action;
    }

    public function setAction(int $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMember1(): Collection
    {
        return $this->member_1;
    }

    public function addMember1(Member $member1): self
    {
        if (!$this->member_1->contains($member1)) {
            $this->member_1[] = $member1;
        }

        return $this;
    }

    public function removeMember1(Member $member1): self
    {
        if ($this->member_1->contains($member1)) {
            $this->member_1->removeElement($member1);
        }

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMember2(): Collection
    {
        return $this->member_2;
    }

    public function addMember2(Member $member2): self
    {
        if (!$this->member_2->contains($member2)) {
            $this->member_2[] = $member2;
        }

        return $this;
    }

    public function removeMember2(Member $member2): self
    {
        if ($this->member_2->contains($member2)) {
            $this->member_2->removeElement($member2);
        }

        return $this;
    }
}

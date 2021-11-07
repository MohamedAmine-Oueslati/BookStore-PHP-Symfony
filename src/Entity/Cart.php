<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Books::class)
     */
    private $book;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, inversedBy="cart", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Books[]
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Books $book): self
    {
        if (!$this->book->contains($book)) {
            $this->book[] = $book;
        }

        return $this;
    }

    public function removeBook(Books $book): self
    {
        $this->book->removeElement($book);

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}

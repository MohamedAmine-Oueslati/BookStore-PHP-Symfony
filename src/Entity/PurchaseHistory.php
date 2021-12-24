<?php

namespace App\Entity;

use App\Repository\PurchaseHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseHistoryRepository::class)
 */
class PurchaseHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\OneToMany(targetEntity=BookPurchased::class, mappedBy="purchaseHistory")
     */
    private $books;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderPlaced;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="purchaseHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection|BookPurchased[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(BookPurchased $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setPurchaseHistory($this);
        }

        return $this;
    }

    public function removeBook(BookPurchased $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getPurchaseHistory() === $this) {
                $book->setPurchaseHistory(null);
            }
        }

        return $this;
    }

    public function getOrderPlaced(): ?\DateTimeInterface
    {
        return $this->orderPlaced;
    }

    public function setOrderPlaced(\DateTimeInterface $orderPlaced): self
    {
        $this->orderPlaced = $orderPlaced;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

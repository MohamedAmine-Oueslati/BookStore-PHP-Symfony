<?php

namespace App\Entity;

use App\Repository\BookPurchasedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookPurchasedRepository::class)
 */
class BookPurchased
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseHistory::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=true)
     */
    private $purchaseHistory;

    /**
     * @ORM\ManyToOne(targetEntity=Books::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPurchaseHistory(): ?PurchaseHistory
    {
        return $this->purchaseHistory;
    }

    public function setPurchaseHistory(?PurchaseHistory $purchaseHistory): self
    {
        $this->purchaseHistory = $purchaseHistory;

        return $this;
    }

    public function getBook(): ?Books
    {
        return $this->book;
    }

    public function setBook(?Books $book): self
    {
        $this->book = $book;

        return $this;
    }
}

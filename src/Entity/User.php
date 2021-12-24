<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Email already used by another account"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message = "Please enter a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5,max=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern = "/^(?=.*[a-z])(?=.*\d).{6,}$/i",message = "Password must contain at least one letter and one number.")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Please make sure your passwords match")
     */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity=Cart::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $cart;

    /**
     * @ORM\OneToOne(targetEntity=Profile::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $Profile;

    /**
     * @ORM\OneToMany(targetEntity=Blog::class, mappedBy="user")
     */
    private $blogs;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseHistory::class, mappedBy="user")
     */
    private $purchaseHistory;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->blogs = new ArrayCollection();
        $this->purchaseHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfile(): ?Profile
    {
        return $this->Profile;
    }

    public function setProfile(?Profile $Profile): self
    {
        $this->Profile = $Profile;

        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setUser($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getUser() === $this) {
                $blog->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PurchaseHistory[]
     */
    public function getPurchaseHistory(): Collection
    {
        return $this->purchaseHistory;
    }

    public function addPurchaseHistory(PurchaseHistory $purchaseHistory): self
    {
        if (!$this->purchaseHistory->contains($purchaseHistory)) {
            $this->purchaseHistory[] = $purchaseHistory;
            $purchaseHistory->setUser($this);
        }

        return $this;
    }

    public function removePurchaseHistory(PurchaseHistory $purchaseHistory): self
    {
        if ($this->purchaseHistory->removeElement($purchaseHistory)) {
            // set the owning side to null (unless already changed)
            if ($purchaseHistory->getUser() === $this) {
                $purchaseHistory->setUser(null);
            }
        }

        return $this;
    }
}

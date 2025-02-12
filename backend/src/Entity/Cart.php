<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToOne(inversedBy: 'cart', cascade: ['persist', 'remove'])]
    private ?User $CartToUser = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'cart')]
    private Collection $CartToProducts;

    public function __construct()
    {
        $this->CartToProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCartToUser(): ?User
    {
        return $this->CartToUser;
    }

    public function setCartToUser(?User $CartToUser): static
    {
        $this->CartToUser = $CartToUser;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getCartToProducts(): Collection
    {
        return $this->CartToProducts;
    }

    public function addCartToProduct(Product $cartToProduct): static
    {
        if (!$this->CartToProducts->contains($cartToProduct)) {
            $this->CartToProducts->add($cartToProduct);
            $cartToProduct->setCart($this);
        }

        return $this;
    }

    public function removeCartToProduct(Product $cartToProduct): static
    {
        if ($this->CartToProducts->removeElement($cartToProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartToProduct->getCart() === $this) {
                $cartToProduct->setCart(null);
            }
        }

        return $this;
    }
}

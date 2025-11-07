<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $totalPriceNoVAT = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'orderClass', orphanRemoval: true)]
    private Collection $items;

    #[ORM\OneToOne(mappedBy: 'orderclass', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalPriceNoVAT(): ?string
    {
        return $this->totalPriceNoVAT;
    }

    public function setTotalPriceNoVAT(string $totalPriceNoVAT): static
    {
        $this->totalPriceNoVAT = $totalPriceNoVAT;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrderClass($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderClass() === $this) {
                $item->setOrderClass(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setOrderclass(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getOrderclass() !== $this) {
            $user->setOrderclass($this);
        }

        $this->user = $user;

        return $this;
    }
}

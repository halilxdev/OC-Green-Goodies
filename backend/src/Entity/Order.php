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

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderObject', orphanRemoval: true)]
    private Collection $item;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $totalPriceNoVAT = null;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(OrderItem $item): static
    {
        if (!$this->item->contains($item)) {
            $this->item->add($item);
            $item->setOrderObject($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): static
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderObject() === $this) {
                $item->setOrderObject(null);
            }
        }

        return $this;
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
}

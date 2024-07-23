<?php

declare(strict_types=1);

namespace NBorschke\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use NBorschke\Repository\CatalogRepository;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
class Catalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: 'integer')]
    private ?int $entityId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categoryName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $shortDesc = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $caffeineType = null;

    #[ORM\Column(type: 'integer')]
    private ?int $count = null;

    #[ORM\Column]
    private ?bool $flavored = false;

    #[ORM\Column]
    private ?bool $seasonal = false;

    #[ORM\Column]
    private ?bool $inStock = false;

    #[ORM\Column]
    private ?bool $facebook = false;

    #[ORM\Column]
    private ?bool $isKCup = false;

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): static
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(?string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDesc(): ?string
    {
        return $this->shortDesc;
    }

    public function setShortDesc(string $shortDesc): static
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(string $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCaffeineType(): ?string
    {
        return $this->caffeineType;
    }

    public function setCaffeineType(string $caffeineType): static
    {
        $this->caffeineType = $caffeineType;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function isFlavored(): ?bool
    {
        return $this->flavored;
    }

    public function setFlavored(bool $flavored): static
    {
        $this->flavored = $flavored;

        return $this;
    }

    public function isSeasonal(): ?bool
    {
        return $this->seasonal;
    }

    public function setSeasonal(bool $seasonal): static
    {
        $this->seasonal = $seasonal;

        return $this;
    }

    public function isInStock(): ?bool
    {
        return $this->inStock;
    }

    public function setInStock(bool $inStock): static
    {
        $this->inStock = $inStock;

        return $this;
    }

    public function isFacebook(): ?bool
    {
        return $this->facebook;
    }

    public function setFacebook(bool $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function isKCup(): ?bool
    {
        return $this->isKCup;
    }

    public function setKCup(bool $isKCup): static
    {
        $this->isKCup = $isKCup;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'entityId' => $this->entityId,
            'categoryName' => $this->categoryName,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'shortDesc' => $this->shortDesc,
            'price' => $this->price,
            'link' => $this->link,
            'image' => $this->image,
            'brand' => $this->brand,
            'rating' => $this->rating,
            'caffeineType' => $this->caffeineType,
            'count' => $this->count,
            'flavored' => (int)$this->flavored,
            'seasonal' => (int)$this->seasonal,
            'inStock' => (int)$this->inStock,
            'facebook' => (int)$this->facebook,
            'isKCup' => (int)$this->isKCup,
        ];
    }
}

<?php

declare(strict_types=1);

namespace NBorschke\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use NBorschke\Repository\CatalogRepository;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
class Catalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: "entityId should not be blank.")]
    private ?int $entityId = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type(type: "string")]
    private ?string $categoryName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type(type: "string")]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type(type: "string")]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Type(type: "string")]
    private ?string $shortDesc = null;

    #[ORM\Column]
    #[Assert\Type(type: "float")]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string")]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string")]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string")]
    private ?string $brand = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Type(type: "integer")]
    #[Assert\Range(min: 0, max: 5)]
    private ?int $rating = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string")]
    private ?string $caffeineType = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Type(type: "integer")]
    private ?int $count = null;

    #[ORM\Column]
    #[Assert\Type(type: "boolean")]
    private ?bool $flavored = false;

    #[ORM\Column]
    #[Assert\Type(type: "boolean")]
    private ?bool $seasonal = false;

    #[ORM\Column]
    #[Assert\Type(type: "boolean")]
    private ?bool $inStock = false;

    #[ORM\Column]
    #[Assert\Type(type: "boolean")]
    private ?bool $facebook = false;

    #[ORM\Column]
    #[Assert\Type(type: "boolean")]
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
        $this->link = trim($link);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = trim($image);

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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
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

<?php

declare(strict_types=1);

namespace NBorschke\Serializer;

use NBorschke\Entity\Catalog;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CatalogNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        private NormalizerInterface|DenormalizerInterface $normalizer,
    ) {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        if (!$object instanceof Catalog) {
            throw new \InvalidArgumentException('Expected an instance of ' . Catalog::class);
        }

        return $object->toArray();
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Catalog
    {
        if ($type !== Catalog::class) {
            throw new \InvalidArgumentException('Expected class ' . Catalog::class);
        }

        $catalog = new Catalog();
        $catalog
            ->setEntityId((int)($data['entity_id'] ?? 0))
            ->setCategoryName($data['CategoryName'] ?? '')
            ->setSku((string)($data['sku'] ?? ''))
            ->setName($data['name'] ?? '')
            ->setDescription($data['description'] ?? '')
            ->setShortDesc($data['shortdesc'] ?? '')
            ->setPrice((float)($data['price'] ?? 0.0))
            ->setLink($data['link'] ?? '')
            ->setImage($data['image'] ?? '')
            ->setBrand($data['Brand'] ?? '')
            ->setRating($data['Rating'] ?? '')
            ->setCaffeineType($data['CaffeineType'] ?? '')
            ->setCount((int)($data['Count'] ?? 0))
            ->setFlavored((bool)($data['Flavored'] ?? false))
            ->setSeasonal((bool)($data['Seasonal'] ?? false))
            ->setInStock((bool)($data['Instock'] ?? false))
            ->setFacebook((bool)($data['Facebook'] ?? false))
            ->setKCup((bool)($data['IsKCup'] ?? false));

        return $catalog;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Catalog;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Catalog::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->normalizer->getSupportedTypes($format);
    }
}
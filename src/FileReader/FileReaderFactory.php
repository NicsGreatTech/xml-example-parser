<?php

namespace NBorschke\FileReader;

use Symfony\Component\Serializer\SerializerInterface;

class FileReaderFactory
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }
    public function createReader(string $fileType): FileReaderInterface
    {
        return match ($fileType) {
            default => new XmlFileReader($this->serializer),
        };
    }
}
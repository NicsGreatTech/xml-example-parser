<?php

namespace NBorschke\FileReader;

use Symfony\Component\Serializer\SerializerInterface;

class XmlFileReader implements FileReaderInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    public function read(string $filePath, int $batchSize = 1000): iterable
    {
        $xmlReader = new \XMLReader();
        if (!$xmlReader->open($filePath)) {
            throw new \Exception("Unable to open XML file.");
        }

        $batch = [];
        while ($xmlReader->read() && $xmlReader->name !== 'item');

        while ($xmlReader->name === 'item') {
            $xmlContent = $xmlReader->readOuterXml();
            $itemData = $this->serializer->decode($xmlContent, 'xml');

            $batch[] = $itemData;

            if (count($batch) >= $batchSize) {
                yield $batch;
                $batch = [];
            }

            $xmlReader->next('item');
        }

        if (!empty($batch)) {
            yield $batch;
        }

        $xmlReader->close();
    }
}
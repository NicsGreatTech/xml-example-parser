<?php

namespace NBorschke\FileReader;

interface FileReaderInterface
{
    public function read(string $filePath, int $batchSize = 1000): iterable;
}
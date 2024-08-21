<?php

namespace NBorschke\Service;

use Doctrine\ORM\EntityManagerInterface;
use NBorschke\Entity\Catalog;
use NBorschke\FileReader\FileReaderFactory;
use NBorschke\Repository\CatalogRepository;
use NBorschke\Serializer\CatalogNormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CatalogImportService
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository,
        private readonly CatalogNormalizer $catalogNormalizer,
        private readonly EntityManagerInterface $entityManager,
        private readonly FileReaderFactory $fileReaderFactory,
        private readonly LoggerInterface $logger,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function importCatalog(string $filePath): bool
    {
        $connection = $this->entityManager->getConnection();

        try {
            $connection->beginTransaction();
            $fileReader = $this->fileReaderFactory->createReader(pathinfo($filePath, PATHINFO_EXTENSION));

            foreach ($fileReader->read($filePath) as $batch) {
                foreach ($batch as $item) {
                    $catalog = $this->catalogNormalizer->denormalize($item, Catalog::class);

                    $errors = $this->validateCatalog($catalog);
                    if (count($errors) > 0) {
                        throw new \Exception('Validation failed.');
                    }

                    $this->catalogRepository->insertOrUpdate($catalog);
                }
            }
            $this->entityManager->flush();
            $connection->commit();

        } catch (\Exception $e) {
            $connection->rollBack();
            $connection->close();
            $this->logger->error($e->getMessage());

            return false;
        }
        $connection->close();

        return true;
    }

    public function validateCatalog(Catalog $catalog): array
    {
        $errors = $this->validator->validate($catalog);
        $errorMessages = [];

        foreach ($errors as $error) {
            $message = $error->getMessage() . " Property: {$error->getPropertyPath()}, Id: {$catalog->getEntityId()}";
            $errorMessages[] = $message;
            $this->logger->error($message);
        }

        return $errorMessages;
    }
}
<?php

declare(strict_types=1);

namespace NBorschke\Command;

use NBorschke\Service\CatalogImportService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints\File as FileConstraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'nborschke:import-xml',
    description: 'Import XML Catalog Data',
)]
class ImportCatalogCommand extends Command
{
    public function __construct(
        private readonly CatalogImportService $catalogService,
        private readonly LoggerInterface $logger,
        private readonly ValidatorInterface $validator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import catalog data from an file into the database')
            ->setHelp('This command allows you to import data from an file');

        $this->addArgument('filePath', InputArgument::REQUIRED, 'The path to the file to be imported');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('filePath') ?: null;

        $fileConstraint = new FileConstraint([
            'extensions' => ['xml'],
            'extensionsMessage' => 'The extension of the file is invalid ({{ extension }}). Allowed extensions are {{ extensions }}',
            'mimeTypes' => ['application/xml', 'text/xml'],
            'mimeTypesMessage' => 'The mime type of the file is invalid ({{ type }}). Allowed mime types are {{ types }}',
        ]);

        $errors = $this->validator->validate($filePath, $fileConstraint);

        if ($errors->count() > 0) {
            foreach ($errors as $error) {
                $io->error($error->getMessage());
                $this->logger->error($error->getMessage());
            }

            return Command::FAILURE;
        }

        $importResult = $this->catalogService->importCatalog($filePath);

        if ($importResult){
            $io->success('Data imported successfully');

            return Command::SUCCESS;
        }

        $io->error('Import failed');

        return Command::FAILURE;
    }
}

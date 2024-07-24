<?php

declare(strict_types=1);

namespace NBorschke\Command;

use NBorschke\Entity\Catalog;
use NBorschke\Repository\CatalogRepository;
use NBorschke\Serializer\CatalogNormalizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'nborschke:import-xml',
    description: 'Import XML Catalog Data',
)]
class ImportCatalogCommand extends Command
{
    public function __construct(
        private readonly CatalogNormalizer $catalogNormalizer,
        private readonly LoggerInterface $logger,
        private readonly CatalogRepository $catalogRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import catalog data from an XML file into the database')
            ->setHelp('This command allows you to import data from an XML file');

        $this->addArgument('xmlFile', InputArgument::REQUIRED, 'Path to XML file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $xmlFile = $input->getArgument('xmlFile') ?: null;

        if (!$xmlFile || !file_exists($xmlFile)) {
            $io->error('XML file not found.');
            $this->logger->error('XML file not found at ' . $xmlFile);

            return Command::FAILURE;
        }

        try {
            $encoder = new XmlEncoder();
            $serializer = new Serializer([$this->catalogNormalizer], [$encoder]);
            $xmlContent = file_get_contents($xmlFile);
            $data = $serializer->decode($xmlContent, 'xml');

            foreach ($data['item'] as $item) {
                $catalog = $serializer->denormalize($item, Catalog::class);
                $this->catalogRepository->insertOrUpdate($catalog);
            }
            $io->success('Data imported successfully.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}

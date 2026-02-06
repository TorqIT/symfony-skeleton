<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\FileStorageService;

class TestCommand extends Command
{
    private static $defaultName = 'app:test';

    private $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Test command to demonstrate file storage service.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Example usage of the FileStorageService
        $filePath = 'example.txt';
        $content = 'This is a test file.';

        // Save the file
        $this->fileStorageService->upload($filePath, $content);
        $output->writeln('File saved successfully.');

        return Command::SUCCESS;
    }
}

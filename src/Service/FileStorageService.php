<?php
namespace App\Service;

use League\Flysystem\FilesystemOperator;

class FileStorageService
{
    public function __construct(
        private FilesystemOperator $defaultStorage
    ) {}

    public function upload(string $path, string $contents): void
    {
        $this->defaultStorage->write($path, $contents);
    }
}

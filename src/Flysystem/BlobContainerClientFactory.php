<?php

namespace App\Flysystem;

use AzureOss\Storage\Blob\BlobServiceClient;

class BlobContainerClientFactory {
    public static function createContainerClient(string $connectionString, $containerName) {
        return BlobServiceClient::fromConnectionString($connectionString)->getContainerClient($containerName);
    }
}

<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class MessageFileService
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $nonPrivateDiskRootDirectory = 'awdawd'
    )
    {
    }

    /**
     * @throws IOExceptionInterface
     */
    public function storeTextFile(string $content, string $relativeFilePath): void
    {
        $this->filesystem->mkdir($this->nonPrivateDiskRootDirectory, 0755);
        $filePath = $this->nonPrivateDiskRootDirectory . '/' . $relativeFilePath;
        $this->filesystem->dumpFile($filePath, $content);
    }
}
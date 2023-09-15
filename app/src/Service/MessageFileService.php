<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use App\Service\Interface\MessageFileServiceInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class MessageFileService implements MessageFileServiceInterface
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $nonPrivateDiskRootDirectory
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

    public function getTextFileContents(string $relativeFilePath): string
    {
        $filePath = $this->nonPrivateDiskRootDirectory . '/' . $relativeFilePath;

        if ($this->filesystem->exists($filePath)) {
            return file_get_contents($filePath);
        }

        return '';
    }
}
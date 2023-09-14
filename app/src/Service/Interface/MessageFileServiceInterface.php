<?php

namespace App\Service\Interface;

interface MessageFileServiceInterface
{
    public function storeTextFile(string $content, string $relativeFilePath): void;

    public function getTextFileContents(string $relativeFilePath): string;
}
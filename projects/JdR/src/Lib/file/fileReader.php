<?php

namespace Lib\file;

class JsonFileReader
{
    public function __construct(
        private string $filePath
    ) {
        if (!is_readable($this->filePath)) {
            throw new \InvalidArgumentException(
                sprintf('File does not exist or is not readable: %s', $this->filePath)
            );
        }
    }

    public function read(): string
    {
        return file_get_contents($this->filePath);
    }
}

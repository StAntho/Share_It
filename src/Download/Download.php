<?php

namespace App\Download;

class Download
{
    private string $originalFilename;

    public function __construct(string $originalFilename)
    {
        $this->originalFilename = $originalFilename;
    }

    public function getOriginalFilename(): string
    {
        return $this->originalFilename;
    }
}

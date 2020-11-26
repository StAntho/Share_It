<?php

namespace App\Database;

/**
 * Les objets de la classe File représentent les données de la table "file"
 * 1 instance = 1 ligne
 */
class File
{
    private ?int $id = null;
    private ?string $filename = null;
    private ?string $original_filename = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setid(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->original_filename;
    }

    public function setOriginalFilename(string $original_filename): self
    {
        $this->original_filename = $original_filename;
        return $this;
    }
}

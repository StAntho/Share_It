<?php

namespace App\File;

use Doctrine\DBAL\Types\StringType;
use Psr\Http\Message\UploadedFileInterface;

class UploadService
{
    /**@var string chemin vers le dossier où enregistrer les fichiers */
    public const FILES_DIR = __DIR__ . '/../../files/';

    /**
     * Enregistrer un fichier
     * 
     * @param UploadedFileInterface $file le fichier chargé à enregistrer
     */
    public function saveFile(UploadedFileInterface $file)
    {
        $filename = $this->generateFilename($file);

        //Construire le chemain de destination du fichier
        //Chemin vers le dossier /files/ + nouveau nom de fichier
        $path = self::FILES_DIR . '/' . $filename;

        //Déplacer le fichier
        $file->moveTo($path);
        return $filename;
    }

    /**
     * Générer un nom de fichier aléatoire et unique
     * 
     * @param UploadedFileInterface $file le fichier à enregistrer
     * @return string le nom unique généré
     */
    private function generateFilename(UploadedFileInterface $file): String
    {
        //Générer un nom de fichier unique
        //horodatage + chaine de caractères aléatoires + extension
        $filename = date("YmdHis");
        $filename .= bin2hex(random_bytes(8));
        $filename .= '.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        return $filename;
    }
}

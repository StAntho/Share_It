<?php

namespace App\Database;

use Doctrine\DBAL\Connection;

/**
 * Ce service est en charge de la gestion des données de la table file
 * Elle doit utiliser des objets de la classe File
 */
class FileManager
{
    private Connection $connection;

    /**
     * Les objets FichierManager pourront être demandés en argument dans les controlleurs
     * Pour les instancier, le conteneur de services va lire la liste d'arguments du constructeur
     * Ici, il va d'abord instancier le service Connection pour pouvoir instancier FichierManager
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Récupérer un fichier par son id
     * 
     * @param int $di l'identifiant en base du fichier
     * @return File|null le fichier trouvé ou null en l'absence de résultat
     */
    public function getById(int $id): ?File
    {
        $query = $this->connection->prepare('SELECT * FROM file WHERE id = :id');
        $query->bindValue('id', $id);
        $result = $query->execute();

        //Tableau associatif contenant les données du fichiers, ou false si aucun résultat
        $fileData = $result->fetchAssociative();

        if ($fileData === false) {
            return null;
        }

        //Création d'une instance de Fichier
        return $this->createObject($fileData['id'], $fileData['filename'], $fileData['original_filename']);
    }

    /**
     * Enregistrer un nouveau fichier en base de données
     */
    public function createFile(string $filename, string $originalFilename): File
    {
        //Enregistrer en base de données 
        $this->connection->insert('file', [
            'filename' => $filename,
            'original_filename' => $originalFilename,
        ]);

        //Récupérer l'identifiant généré du fichier enregistré
        $id = $this->connection->lastInsertId();

        //créer un objet File et le retourner
        return $this->createObject($id, $filename, $originalFilename);
    }

    /**
     * Créer un objet File à partir de ses informations
     */
    private function createObject(int $id, string $filename, string $originalFilename): File
    {
        $file = new File();
        $file
            ->setId($id)
            ->setFilename($filename)
            ->setOriginalFilename($originalFilename);
        return $file;
    }
}

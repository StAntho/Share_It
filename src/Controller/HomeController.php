<?php

namespace App\Controller;

use App\Database\FileManager;
use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFile;
use SplFileInfo;
use Twig\Template;

use function DI\string;

class HomeController extends AbstractController
{
    public function homepage(
        ResponseInterface $response,
        ServerRequestInterface $request,
        UploadService $uploadService,
        FileManager $fileManager
    ) {
        // Récupérer les fichiers envoyés:
        $listeFichiers = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listeFichiers['file'])) {
            /** @var UploadedFileInterface $fichier */
            $file = $listeFichiers['file'];

            //Récupérer le nouveau nom du fichier
            $newname = $uploadService->saveFile($file);

            //Enregistrer les infos du fichier en base de données
            $file = $fileManager->createFile($newname, $file->getClientFilename());

            //Redirection vers la page de succès
            return $this->redirect('success', [
                'id' => $file->getId()
            ]);
        }
        return $this->template($response, 'home.html.twig');
    }

    public function success(ResponseInterface $response, int $id, FileManager $filemanager)
    {
        $file = $filemanager->getById($id);
        return $this->template($response, 'success.html.twig', [
            'file' => $file
        ]);
    }

    public function download(ResponseInterface $response, int $id)
    {
        //Affiche 'Identifiant: %d' sur la page download
        $response->getBody()->write(sprintf('Identifiant: %d', $id));
        return $response;
    }
}

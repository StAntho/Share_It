<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFile;
use SplFileInfo;
use Twig\Template;

use function DI\string;

class HomeController extends AbstractController
{
    public function homepage(ResponseInterface $response, ServerRequestInterface $request)
    {
        // Récupérer les fichiers envoyés:
        $listeFichiers = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listeFichiers['file'])) {
            /** @var UploadedFileInterface $fichier */
            $file = $listeFichiers['file'];

            /**
             * Méthodes à utiliser de $fichier:
             *      getClientFilename()     nom original du fichier
             *      getError()              code d'erreur
             *      moveTo()                déplacer le fichier
             */
            //$nouveau_nom = '...';
            // $fichier->moveTo($nouveauNom);

            //Générer un nom de fichier unique
            //horodatage + chaine de caractères aléatoires + extension
            $filename = date("YmdHis");
            $filename .= bin2hex(random_bytes(8));
            $filename .= '.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

            //Construire le chemain de destination du fichier
            //Chemin vers le dossier /files/ + nouveau nom de fichier
            $path = __DIR__ . '/../../files/' . $filename;

            //Déplacer le fichier
            $file->moveTo($path);
        }
        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        //Affiche 'Identifiant: %d' sur la page download
        $response->getBody()->write(sprintf('Identifiant: %d', $id));
        return $response;
    }
}

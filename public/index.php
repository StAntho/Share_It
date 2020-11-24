<?php

/**
 * This file is the Front Controller
 * HTTP traffic must be redirected to this file
 *
 * @var App $app
 */

use App\Controller\HomeController;
use Slim\App;

// App configuration
require_once __DIR__ . '/../config/bootstrap.php';

// Application routes
$app
    ->map(['GET', 'POST'], '/', [HomeController::class, 'homepage'])
    ->setName('homepage');

//On peut indiquer des paramètres dans les routes entre accolades: {param}
//On peut indiquer leur format avec des regEx: \d+ (constitué d'un ou plusieurs chiffres)
//Les paramètres seront envoyés en arguent de la méthode du cotrolleur
$app
    ->get('/download/{id:\d+}', [HomeController::class, 'download'])
    ->setName('download');


// Start the application
$app->run();

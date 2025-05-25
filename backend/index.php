<?php

require "vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/rest/services/BaseService.php';
require_once __DIR__ . '/rest/services/AdoptionService.php';
require_once __DIR__ . '/rest/services/MedicalRecordService.php';
require_once __DIR__ . '/rest/services/PetService.php';
require_once __DIR__ . '/rest/services/ReviewService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/AuthService.php';

require_once __DIR__ . '/middleware/AuthMiddleware.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', 'AuthMiddleware');
Flight::register('user_service', 'UserService');
Flight::register('review_service', 'ReviewService');
Flight::register('pet_service', 'PetService');
Flight::register('medical_record_service', 'MedicalRecordService');
Flight::register('adoption_service', 'AdoptionService');

Flight::route('/*', function () {
    $publicRoutes = [
        '/auth/login',
        '/auth/register',
        '/users/add_user',
        '/users',
        '/adoptions/approved'
    ];

    $url = Flight::request()->url;

    foreach ($publicRoutes as $route) {
        if (strpos($url, $route) === 0) {
            error_log("Public route accessed: $url");
            return true;
        }
    }

    error_log("Secured route: $url");
    return Flight::auth_middleware()->verifyToken();
});


require_once __DIR__ . '/rest/routes/AdoptionRoutes.php';
require_once __DIR__ . '/rest/routes/MedicalRecordRoutes.php';
require_once __DIR__ . '/rest/routes/PetRoutes.php';
require_once __DIR__ . '/rest/routes/ReviewRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/AuthRoutes.php';

Flight::start();

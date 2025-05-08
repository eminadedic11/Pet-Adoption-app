<?php

require 'vendor/autoload.php';

require 'rest/routes/AdoptionRoutes.php';
require 'rest/routes/MedicalRecordRoutes.php';
require 'rest/routes/PetRoutes.php';
require 'rest/routes/ReviewRoutes.php';
require 'rest/routes/UserRoutes.php';

// Flight::route('GET /', function() {
//     return Flight::json('Hello World!');
// });

Flight::start();
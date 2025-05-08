<?php

require __DIR__ . '/../../../vendor/autoload.php';

define('BASE_URL', 'https://localhost:80/pet-adoption-app/backend/');


error_reporting(0);

$openapi = \OpenApi\Generator::scan(['../../../rest/routes/', './']);

header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
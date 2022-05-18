<?php

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

require_once('model.php');
$Model = new Model();

$parameter = json_decode(file_get_contents('php://input'), true);

$latitude = $parameter['latitude'];
$longitude = $parameter['longitude'];

$result = json_encode($topThree);
header("Content-Type: application/json;");
echo $result;
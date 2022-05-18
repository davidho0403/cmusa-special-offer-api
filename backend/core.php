<?php

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

function calcDistance($store_list, $latitude, $longitude) {
    $count = 0;
    while (count($store_list) - $count >= 20) {
        $api_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations=';
        for ($i = $count; $i < $count + 20; $i++) {
            $api_url .= $store_list[$i]['store_address'];
            if ($i < $count + 19) {
                $api_url .= '|';
            }
        }
        $api_url .=  '&origins=' . $latitude . '%2C' . $longitude . '&key=' . $_ENV['GOOGLE_API_KEY'];

        $result = json_decode(file_get_contents($api_url), true);
        for ($i = $count; $i < $count + 20; $i++) {
            $store_list[$i]['distance'] = $result['rows'][0]['elements'][$i - $count]['distance']['value'];
        }

        $count += 20;
    }
    $api_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations=';
    for ($i = $count; $i < count($store_list); $i++) {
        $api_url .= $store_list[$i]['store_address'];
        if ($i < count($store_list) - 1) {
            $api_url .= '|';
        }
    }
    $api_url .=  '&origins=' . $latitude . '%2C' . $longitude . '&key=' . $_ENV['GOOGLE_API_KEY'];

    $result = json_decode(file_get_contents($api_url), true);
    for ($i = $count; $i < count($store_list); $i++) {
        $store_list[$i]['distance'] = $result['rows'][0]['elements'][$i - $count]['distance']['value'];
    }
    return $store_list;
}

function getTopThree($store_list) {
    for ($i = 0; $i < count($store_list); $i++) {
        for ($j = 0; $j < $i; $j++) {
            if ($store_list[$i]['distance'] < $store_list[$j]['distance']) {
                $temp = $store_list[$i];
                $store_list[$i] = $store_list[$j];
                $store_list[$j] = $temp;
            }
        }
    }
    $result = array();
    $result[0] = $store_list[0];
    $result[1] = $store_list[1];
    $result[2] = $store_list[2];

    return $result;
}

require_once('model.php');
$Model = new Model();

$parameter = json_decode(file_get_contents('php://input'), true);

$latitude = $parameter['latitude'];
$longitude = $parameter['longitude'];

$result = json_encode($topThree);
header("Content-Type: application/json;");
echo $result;
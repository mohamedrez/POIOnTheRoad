<?php
require_once __DIR__.'/vendor/autoload.php';

use \POI\NearestPOIFinder;

$myKey = "AIzaSyDRcbylh07I94ewnVzwokn7pxogZYXObhU";
$client = new Google_Client();
// set your API Key
$client->setDeveloperKey($myKey);

// get the authorized HTTP Client object
$http = $client->authorize();

// make the call!
$url = 'https://maps.googleapis.com/maps/api/directions/json'
        .'?origin=33.5443856,-7.5828153'
        .'&destination=33.5395478,-7.5993346';

$response = $http->get($url);

$result = json_decode($response->getBody()->getContents());
// $result = $response->getBody()->getContents();
$encoded_polyline = $result->routes[0]->overview_polyline->points;
// $encoded_polyline = "kiw~FpoavObBA?fAzEC";
$polyline = Polyline::decode($encoded_polyline);

print var_dump($polyline);

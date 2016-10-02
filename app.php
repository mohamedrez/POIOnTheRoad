<?php
require_once __DIR__.'/vendor/autoload.php';

$myKey = "AIzaSyDRcbylh07I94ewnVzwokn7pxogZYXObhU";
$client = new Google_Client();
// set your API Key
$client->setDeveloperKey($myKey);

// get the authorized HTTP Client object
$http = $client->authorize();

// make the call!
$url = 'https://maps.googleapis.com/maps/api/directions/json'
        .'?origin=Disneyland'
        .'&destination=Universal+Studios+Hollywood';

$response = $http->get($url);

print var_dump($response->getBody()->getContents());

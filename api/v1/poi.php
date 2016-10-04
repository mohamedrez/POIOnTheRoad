<?php

require_once __DIR__.'/../../vendor/autoload.php';

use \POI\NearPOIToPolyLineFinder;
use \POI\PolylineFetcher;
use \POI\PointOfInterest;
use \Doctrine\DBAL\Configuration;
use \Doctrine\DBAL\DriverManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

date_default_timezone_set('GMT');


$myKey = "AIzaSyDRcbylh07I94ewnVzwokn7pxogZYXObhU";
$client = new Google_Client();
$client->setDeveloperKey($myKey);

$request = Request::createFromGlobals();
$response = new Response();

$origin = explode(',', $request->get('origin'));
$destination = explode(',', $request->get('destination'));

$polylineFetcher = new PolylineFetcher($client, $origin, $destination);
$polyline = $polylineFetcher->getPoints();


$config = new Configuration();
$connectionParams = array(
    'path' => __DIR__.'/../../db/poi.db',
    'driver' => 'pdo_sqlite'
);
$db = DriverManager::getConnection($connectionParams, $config);

$pointOfInterest = new PointOfInterest($db);
$data = $pointOfInterest->all();

$nearPois = array();
foreach ($data as $point)
{
  $formatedLatLong = array($point['latitude'], $point['longitude']);
  if(NearPOIToPolyLineFinder::isNearToPolyline($polyline, $formatedLatLong)){
    $nearPois[] =  $point;
  }
}
$response = new Response();
if($nearPois)
{
  $response->headers->set('Content-Type', 'application/json');
  $response->setContent(json_encode($nearPois));
  $response->setStatusCode(Response::HTTP_OK);
}else{
  $response->setStatusCode(Response::HTTP_NOT_FOUND);
}

$response->send();

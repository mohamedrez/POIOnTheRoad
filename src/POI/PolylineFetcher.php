<?php namespace POI;

Class PolylineFetcher
{
  public function __construct(\Google_Client $client, $pointFrom, $pointTo){
    $this->client = $client;
    $this->pointFrom = $pointFrom;
    $this->pointTo = $pointTo;
  }

  public function getEncodedPolyline(){

    $http = $this->client->authorize();
    $url = 'https://maps.googleapis.com/maps/api/directions/json'
            .'?origin='.$this->pointFrom[0].','.$this->pointFrom[1]
            .'&destination='.$this->pointTo[0].','.$this->pointTo[1];

    $response = $http->get($url);

    $result = json_decode($response->getBody()->getContents());
    $encodedPolyline = $result->routes[0]->overview_polyline->points;
    return $encodedPolyline;

  }

  public function getPoints(){
    $encodedPolyline = $this->getEncodedPolyline();
    $polyline = \Polyline::decode($encodedPolyline);
    $points = \Polyline::pair($polyline);
    return $points;
  }

}

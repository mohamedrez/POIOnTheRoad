<?php
use PHPUnit\Framework\TestCase;
use POI\PolylineFetcher;

class PolylineFetcherTest extends PHPUnit_Framework_TestCase
{

  protected function setUp()
  {
    $client = new \Google_Client();

    $this->polylineFetcher = $this->getMockBuilder('POI\PolylineFetcher')
    ->setConstructorArgs(array($client, array(33.5296478,-7.5929862), array(33.5445644,-7.5825578)))
    ->setMethods(array('getEncodedPolyline'))
    ->getMock();

    $encoded_polyline_stubbed = "iwskEb_jm@BHODgANqE|@_@Dk@AWBoCd@e@R]ZsBnAqFzCMFgBqKc@GaAa@gCuAwEeCm@g@a@u@OQYMqAm@sAk@iBeA_@OYEm@F}A\wEfA_AZWmB[cCu@eE]}BsA}Kw@oFOq@uBmEuCaG{@p@_QdNOLNXPKnFqEjJmH";

    $this->polylineFetcher->expects($this->any())
    ->method('getEncodedPolyline')
    ->will($this->returnValue($encoded_polyline_stubbed));
  }

  public function testGetPoints()
  {
    $polyline = json_decode(file_get_contents(__DIR__."/fixtures/polyline.json"), true);
    $this->assertEquals($polyline, $this->polylineFetcher->getPoints());
  }
}

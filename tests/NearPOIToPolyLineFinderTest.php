<?php
use PHPUnit\Framework\TestCase;
use POI\NearPOIToPolyLineFinder;

class NearPOIToPolyLineFinderTest extends PHPUnit_Framework_TestCase
{

  protected function setUp()
  {
    $this->polyline =
      json_decode(file_get_contents(__DIR__."/fixtures/polyline.json"), true);
  }

  public function testIsNearToPolyline(){
    $isNear = NearPOIToPolyLineFinder::isNearToPolyline(
      $this->polyline, array(33.5443856,-7.5828153));
    $this->assertTrue($isNear);

    $isNotNear = NearPOIToPolyLineFinder::isNearToPolyline(
      $this->polyline, array(33.54937,-8.59593));
    $this->assertFalse($isNotNear);
  }
}

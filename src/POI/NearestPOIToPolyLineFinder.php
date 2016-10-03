<?php namespace POI;

Class NearestPOIToPolyLineFinder
{

  public static function isNearToPolyline(array $polyline, array $point,  $max_distance = 500){
    foreach ($polyline as $pointInPolyline) {
      $distance = self::getDistanceInMeter($point, $pointInPolyline);
      if(distance < $max_distance){
        return true;
      }
    }
    return false;
  }

  public static function getDistanceInMeter(
    array $pointFrom, array $pointTo)
  {
    $earthRadius = 6371000;
    // convert from degrees to radians
    $latFrom = deg2rad($pointFrom[0]);
    $lonFrom = deg2rad($pointFrom[1]);
    $latTo = deg2rad($pointTo[0]);
    $lonTo = deg2rad($pointTo[1]);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
      pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    return $angle * $earthRadius;
  }
}

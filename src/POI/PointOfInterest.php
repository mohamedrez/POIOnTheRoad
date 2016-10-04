<?php namespace POI;

Class PointOfInterest
{

  private $db;
  public function __construct($db)
  {
    $this->db = $db;
  }

  public function all()
  {
    return $this->db->fetchAll("SELECT * FROM `poi`");
  }

}

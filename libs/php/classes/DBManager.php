<?php

// Db Manager Class


class DBManager {

  private $conn;

  public function __construct() {
    try {
      $this->conn = new PDO('mysql:host=db;dbname=nsaservices_db', 'admin', 'test123');

    } catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  public static function getConn(){
    return new PDO('mysql:host=db;dbname=nsaservices_db', 'admin', 'test123');
  }

}



?>

<?php

/**
 *
 */
class Intervention {

  private $id;
  private $partner_id;
  private $order_id;
  private $intervention_date;

  function __construct($id, $partner_id, $order_id, $intervention_date) {
    $this->id = $id;
    $this->partner_id = $partner_id;
    $this->order_id = $order_id;
    $this->intervention_date = $intervention_date;
  }

  // Getters

  public function getID() {
    return $this->id;
  }

  public function getPID() {
    return $this->partner_id;
  }

  public function getOID() {
    return $this->order_id;
  }

  public function getInterventionDate() {
    return $this->intervention_date;
  }

  // Setters
  // A voir si on en met ou pas


  // -----------------------
  // Methods

  public function getAllInterventions() {

    $sql = "SELECT * FROM intervention";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute();

    $result = array();

    while ($row = $req->fetch()) {
      $result[] = new Intervention($row["id"], $row["partner_id"], $row["order_id"], $row["intervention_date"]);
    }

    return $result;
  }
}


?>

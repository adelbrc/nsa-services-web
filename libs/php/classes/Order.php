<?php

/**
 *
 */
class Order {

  private $order_id;
  private $customer_id;
  private $order_date;
  private $nbHours;
  private $service_id;
  private $payment_status;
  private $reservation_date;
  private $order_status;

  function __construct($order_id, $customer_id, $order_date, $nbHours, $service_id, $payment_status, $reservation_date, $order_status) {
    $this->order_id = $order_id;
    $this->customer_id = $customer_id;
    $this->order_date = $order_date;
    $this->nbHours = $nbHours;
    $this->service_id = $service_id;
    $this->payment_status = $payment_status;
    $this->reservation_date = $reservation_date;
    $this->order_status = $order_status;
  }

  // -------------------
  // Getters

  public function getOrderId(){
    return $this->order_id;
  }

  public function getCustomerId(){
    return $this->customer_id;
  }

  public function getOrderDate(){
    return $this->order_date;
  }

  public function getNbHours(){
    return $this->nbHours;
  }

  public function getServiceId(){
    return $this->service_id;
  }

  public function getPaymentStatus(){
    return $this->payment_status;
  }

  public function getReservationDate(){
    return $this->reservation_date;
  }

  public function getOrderStatus(){
    return $this->order_status;
  }



  // ----------------------
  // Methods

  // Get an order by ID
  public function getOrderByID($id){

    $sql = "SELECT * FROM nsaservices_db.order WHERE order_id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$id]);

    if ($row = $req->fetch()) {
      return new Order($row["order_id"], $row["customer_id"], $row["order_date"],
      $row["nbHours"], $row["service_id"], $row["payment_status"], $row["reservation_date"],
      $row["order_status"]);
    }else {
      return NULL;
    }
  }

  // Get user's orders
  public function getUserOrders($uid) {

    $sql = "SELECT * FROM nsaservices_db.order WHERE customer_id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$uid]);

    $result = array();

    while ($row = $req->fetch()) {
      $result[] = new Order($row["order_id"], $row["customer_id"], $row["order_date"],
      $row["nbHours"], $row["service_id"], $row["payment_status"], $row["reservation_date"],
      $row["order_status"]);
    }

    return $result;
  }

  // List all orders
  public static function getAllOrders(){

    $sql = "SELECT * FROM nsaservices_db.order ORDER BY order_date DESC";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute();

    $result = array();

    while ($row = $req->fetch()) {
      $result[] = new Order($row["order_id"], $row["customer_id"], $row["order_date"],
      $row["nbHours"], $row["service_id"], $row["payment_status"], $row["reservation_date"],
      $row["order_status"]);
    }

    return $result;
  }


  // Cancel an order
  public function cancel(){

    if ($this->order_status != 2) {

      $this->order_status = 2;

      $sql = "UPDATE nsaservices_db.order SET order_status = ? WHERE order_id = ?";
      $req = $GLOBALS["conn"]->prepare($sql);
      $req->execute([2, $this->order_id]);

      return true;
    }else {
      return false;
    }
  }
}


?>

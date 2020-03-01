<?php

require_once("DBManager.php");

$conn = DBManager::getConn();

// Service

class Service {

  private $id;
  private $name;
  private $price;
  private $discount_price;
  private $description;
  private $category_id;
  private $stripe_id;


  function __construct($id, $name, $price, $discount_price, $description, $category_id, $stripe_id) {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->discount_price = $discount_price;
    $this->description = $description;
    $this->$category_id = $category_id;
    $this->stripe_id = $stripe_id;
  }

  // ----------------
  // Getters
  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getPrice(){
    return $this->price;
  }

  public function getDiscountPrice(){
    return $this->discount_price;
  }

  public function getDescription(){
    return $this->description;
  }

  public function getCategoryId(){
    return $this->$category_id;
  }

  public function getStripeID() {
      return $this->stripe_id;
  }

  // -----------------
  // Setters
  public function setName($name){
    $this->name = $name;
  }

  public function setPrice($price){
   $this->price = $price;
  }

  public function setDiscountPrice($price){
    $this->discount_price = $price;
  }

  public function setDescription($description){
    $this->description = $description;
  }


  // -----------------
  // Methods

  // Insert a service in database
  public function addService(Service $service){
    $sql = "INSERT INTO service(name, price, discountPrice, description, category_id, id_service) VALUES(:n, :p, :dp, :d, :c, :sid)";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute(array(
      "n" => $service->getName(),
      "p" => $service->getPrice(),
      "dp" => $service->getDiscountPrice(),
      "d" => $service->getDescription(),
      "c" => $service->getCategoryId(),
      "sid" => $service->getStripeID(),
    ));
  }

  // Get a service by ID
  public function getServiceById($id){
    $sql = "SELECT * FROM service WHERE id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$id]);

    if ($row = $req->fetch()) {
      return new Service($row["id"], $row["name"], $row["price"], $row["discountPrice"], $row["description"], $row["category_id"], $row["id_service"]);
    }else {
      return NULL;
    }
  }

  // Get an array of services objects
  public static function getAllServices(){
    $sql = "SELECT * FROM service LIMIT 5";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute();

    $result = array();
    while ($row = $req->fetch()) {
      $result[] = new Service($row["id"], $row["name"], $row["price"], $row["discountPrice"], $row["description"], $row["category_id"], $row["id_service"]);
    }

    return $result;
  }

  // Get Serice Category Name
  public function getServiceCategory() {

    $sql = "SELECT category.name FROM service INNER JOIN category ON service.category_id = category.id WHERE service.id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$this->id]);

    return $req->fetch()[0];
  }


  // Search Service
  public function searchService($input) {

    $sql = "SELECT * FROM service WHERE name LIKE :str";
    $query = $GLOBALS['conn']->prepare($sql);
    $query->execute(array(
      'str' => $input . "%",
    ));

    $results = [];

    while ($row = $query->fetch()) {
      $results[] = new Service($row["id"], $row["name"], $row["price"], $row["discountPrice"], $row["description"], $row["category_id"], $row["id_service"]);
    }

    return $results;
  }



}


?>

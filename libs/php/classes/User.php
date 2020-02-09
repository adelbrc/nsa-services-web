<?php

require_once("DBManager.php");

$conn = DBManager::getConn();

// User Class


class User {

  private int $id;
  private string $firtsname;
  private string $lastname;
  private string $email;
  private string $password;
  private string $phone;
  private string $address;
  private string $city;
  private int $rank;

  public function __construct($firtsname, $lastname, $email, $password, $phone, $address, $city){
    $this->firtsname = $firtsname;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->password = $password;
    $this->phone = $phone;
    $this->address = $address;
    $this->city = $city;
  }

  // -----------------
  // Getters
  public function getUID() : int {
    return $this->id;
  }

  public function getFirstname() : string{
    return $this->firstname;
  }

  public function getLastname() : string{
    return $this->lastname;
  }

  public function getEmail() : string{
    return $this->email;
  }

  public function getPassword() : string{
    return $this->password;
  }

  public function getPhoneNumber() : string{
    return $this->phone;
  }

  public function getAddress() : string{
    return $this->address;
  }

  public function getCity() : string{
    return $this->city;
  }

  public function getRank() : int{
    return $this->firstname;
  }

  // ----------------------------
  // Setters
  public function setFirstname(string $fname) : void {
    $this->firstname = $fname;
  }

  public function setLastname(string $lname) : void {
    $this->lastname = $lname;
  }

  public function setEmail(string $email) : void {
    $this->email = $email;
  }

  public function setPassword(string $pass) : void {
    $this->password = $pass;
  }

  public function setPhoneNumber(string $phone) : void {
    $this->phone = $phone;
  }

  public function setAddress(string $addr) : void {
    $this->address = $addr;
  }

  public function setCity(string $city) : void {
    $this->city = $city;
  }

  public function setRank(int $rank) : void {
    $this->rank = $rank;
  }

  // ----------------
  // Methods

  // Adding a user to the database
  public function addUser(User $user) {

    $sql = "INSERT INTO user(firstname, lastname, email, password, phone_number, address, city)
    VALUES(:fname, :lname, :email, :pass, :phone, :addr, :city)";
    $req = $GLOBALS['conn']->prepare($sql);
    $req->execute(array(
      "fname" => $user->getFirstname(),
      "lname" => $user->getLastname(),
      "email" => $user->getEmail(),
      "pass" => $user->getPassword(),
      "phone" => $user->getPhoneNumber(),
      "addr" => $user->getAddress(),
      "city" => $user->getCity(),
    ));
  }

  // Loading user infos
  public function loadUser(string $email) {

    $sql = "SELECT * FROM user WHERE email = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$email]);

    if ($row = $req->fetch()) {
      return new User($row["firstname"], $row["lastname"], $row["email"], $row["password"], $row["phone_number"], $row["address"], $row["city"], $row["rank"]);
    }else {
      return NULL;
    }
  }

}


?>

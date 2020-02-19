<?php

require_once("DBManager.php");

$conn = DBManager::getConn();

// User Class

class User {

  private $id;
  private $firstname;
  private $lastname;
  private $email;
  private $password;
  private $profile_pic;
  private $phone;
  private $address;
  private $city;
  private $rank;

  public function __construct($id, $firstname, $lastname, $email, $password, $profile_pic, $phone, $address, $city, $rank){
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->password = $password;
    $this->profile_pic = $profile_pic;
    $this->phone = $phone;
    $this->address = $address;
    $this->city = $city;
    $this->rank = $rank;
  }

  // -----------------
  // Getters
  public function getUID() {
    return $this->id;
  }

  public function getFirstname() {
    return $this->firstname;
  }

  public function getLastname() {
    return $this->lastname;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getProfilePic() {
    return $this->profile_pic;
  }

  public function getPhoneNumber() {
    return $this->phone;
  }

  public function getAddress() {
    return $this->address;
  }

  public function getCity() {
    return $this->city;
  }

  public function getRank(){
    return $this->rank;
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

  public function setProfilePic(string $path) : void {
    $this->profile_pic = $path;
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
  public function signup($fname, $lname, $email, $pass, $phone, $addr, $city) {

    $sql = "INSERT INTO user(firstname, lastname, email, password, phone_number, address, city)
    VALUES(:fname, :lname, :email, :pass, :phone, :addr, :city)";
    $req = $GLOBALS['conn']->prepare($sql);
    $req->execute(array(
      "fname" => $fname,
      "lname" => $lname,
      "email" => $email,
      "pass" => $pass,
      "phone" => $phone,
      "addr" => $addr,
      "city" => $city,
    ));
  }

  // Loading user infos
  public function loadUser(string $email){

    $sql = "SELECT * FROM user WHERE email = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$email]);

    if ($row = $req->fetch()) {
      return new User($row["id"], $row["firstname"], $row["lastname"], $row["email"], $row["password"], $row["profile_picture"], $row["phone_number"], $row["address"], $row["city"], $row["rank"]);
    }else {
      return NULL;
    }
  }

  // User updating infos
  public function updateUserInfos($email, $pass, $profile_pic, $phone, $address, $city){

    $this->email = $email;
    $this->password = $pass;
    $this->profile_pic = $profile_pic;
    $this->phone = $phone;
    $this->address = $address;
    $this->city = $city;

    $sql = "UPDATE user SET email = :mail, password = :pwd, profile_picture = :profilepic, phone_number = :phonenumb, address = :addr, city = :city WHERE id = :uid";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute(array(
      "mail" => $email,
      "pwd" => $pass,
      "profilepic" => $profile_pic,
      "phonenumb" => $phone,
      "addr" => $address,
      "city" => $city,
      "uid" => $this->id,
    ));
  }

  // Get user by ID
  public static function getUserByID(int $id): User{

    $sql = "SELECT * FROM user WHERE id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$id]);

    if ($row = $req->fetch()) {
      return new User($row["id"], $row["firstname"], $row["lastname"], $row["email"], $row["password"], $row["profile_picture"], $row["phone_number"], $row["address"], $row["city"], $row["rank"]);
    }else {
      return NULL;
    }
  }

  // Get all users
  public function getAllUsers(){

    $sql = "SELECT * FROM user";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute();

    $result = array();

    while ($row = $req->fetch()) {
      $result[] = new User($row["id"], $row["firstname"], $row["lastname"], $row["email"], $row["password"], $row["profile_picture"], $row["phone_number"], $row["address"], $row["city"], $row["rank"]);
    }

    return $result;
  }

  // Delete user from database
  public function deleteUser(int $id) : void{

    $sql = "DELETE FROM user WHERE id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$id]);

  }

  // Set user to admin
  public function setAdmin(User $user) : void{

    $sql = "UPDATE user SET user.rank = 3 WHERE user.id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$user->getId()]);

  }

}


?>

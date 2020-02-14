<?php

class Partner {

  private $partner_id;
  private $corp_name;
  private $corp_id;
  private $lastname;
  private $firstname;
  private $role_id;
  private $address;
  private $city;
  private $email;
  private $password;
  private $phone;
  private $qrcode;
  private $pricing;
  private $disponibility_begin;
  private $disponibility_end;

  function __construct($id, $corp_name, $corp_id, $lastname, $firstname, $role_id, $address, $city, $email, $password, $phone, $qrcode, $pricing, $disponibility_begin, $disponibility_end) {
    $this->partner_id = $id;
    $this->corp_name = $corp_name;
    $this->corp_id = $corp_id;
    $this->lastname = $lastname;
    $this->firstname = $firstname;
    $this->role_id = $role_id;
    $this->address = $address;
    $this->city = $city;
    $this->email = $email;
    $this->password = $password;
    $this->phone = $phone;
    $this->qrcode = $qrcode;
    $this->pricing = $pricing;
    $this->disponibility_begin = $disponibility_begin;
    $this->disponibility_end = $disponibility_end;
  }

  // ---------------------------
  // Getters
  public function getPID(){
    return $this->partner_id;
  }

  public function getFirstname(){
    return $this->firstname;
  }

  public function getLastName(){
    return $this->lastname;
  }

  public function getCorpName(){
    return $this->corp_name;
  }

  public function getCorpId(){
    return $this->corp_id;
  }

  public function getRoleId(){
    return $this->role_id;
  }

  public function getAddress(){
    return $this->address;
  }

  public function getCity(){
    return $this->city;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getPassword(){
    return $this->address;
  }

  public function getPhoneNumber(){
    return $this->phone;
  }

  public function getQRCode(){
    return $this->qrcode;
  }

  public function getPricing(){
    return $this->pricing;
  }

  public function getDisponibilityBegin(){
    return $this->disponibility_begin;
  }

  public function getDisponibilityEnd(){
    return $this->disponibility_end;
  }

  // -------------------------
  // Setters
  public function setCorpName($name){
    $this->corp_name = $name;
  }

  public function setCorpId($id){
    $this->corp_id = $id;
  }

  public function setRoleId($id){
   $this->role_id = $id;
  }

  public function setQRCode($qrcode){
   $this->qrcode = $qrcode;
  }

  public function setPricing($price){
   $this->pricing = $price;
  }

  public function setDisponibilityBegin($date){
   $this->disponibility_begin = $date;
  }

  public function setDisponibilityEnd($date){
   $this->disponibility_end = $date;
  }

  // ------------------------------------
  // Methods

  // Get a partner by ID
  public function getPartnerById($id){
    $sql = "SELECT * FROM partner WHERE partner_id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$id]);

    if ($row = $req->fetch()) {
      return new Partner($row["partner_id"], $row["corporation_name"], $row["corporation_id"],
      $row["lastname"], $row["firstname"], $row["role_id"], $row["address"],
      $row["city"], $row["email"], $row["password"], $row["phone"], $row["qrcode"], $row["pricing"],
      $row["disponibility_begin"], $row["disponibility_end"]);
    }else {
      return NULL;
    }
  }

  // Get a partner's role with role ID
  public function getRoleById($id){
    $sql = "SELECT name FROM role WHERE id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$id]);

    $result = $req->fetch();
    return $result["name"];
  }

  // List all partners
  public function getAllPartners(){
    $sql = "SELECT * FROM partner";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute();

    $result = array();

    while ($row = $req->fetch()) {
      $result[] = new Partner($row["partner_id"], $row["corporation_name"], $row["corporation_id"],
      $row["lastname"], $row["firstname"], $row["role_id"], $row["address"],
      $row["city"], $row["email"], $row["password"], $row["phone"], $row["qrcode"], $row["pricing"],
      $row["disponibility_begin"], $row["disponibility_end"]);
    }

    return $result;
  }

  // Update a partner's infos
  // User updating infos
  public function updatePartnerInfos($pid, $corp_name, $corp_id, $role_id, $address, $city, $email, $phone, $pricing, $dispo_begin, $dispo_end){

    $this->corporation_name = $corp_name;
    $this->corporation_id = $corp_id;
    $this->role_id = $role_id;
    $this->address = $address;
    $this->city = $city;
    $this->email = $email;
    $this->phone = $phone;
    $this->pricing = $pricing;
    $this->disponibility_begin = $dispo_begin;
    $this->disponibility_end = $dispo_end;

    $sql = "UPDATE partner SET corporation_name = :corp_n, corporation_id = :corp_d, role_id = :rid, address = :addr, city = :ct, email = :mail, phone = :phonenumb, pricing = :price, disponibility_begin = :dispo_beg, disponibility_end = :dispo_end WHERE partner_id = :pid";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute(array(
      "corp_n" => $corp_name,
      "corp_d" => $corp_id,
      "rid" => $role_id,
      "addr" => $address,
      "ct" => $city,
      "mail" => $email,
      "phonenumb" => $phone,
      "price" => $pricing,
      "dispo_beg" => $dispo_begin,
      "dispo_end" => $dispo_end,
      "pid" => $pid,
    ));
  }

}




?>

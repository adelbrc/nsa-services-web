<?php

require_once("Contract.php");
require_once("DBManager.php");

$conn = DBManager::getConn();


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
  public static function getPartnerById($id){
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

  // ------------------
  // Check if PID exists
  public function checkPID($pid){

    $sql = "SELECT partner_id FROM partner WHERE partner_id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$pid]);

    $res[] = $req->fetch();

    echo count($res);
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
  public static function getAllPartners(){
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

  // ------------------------
  // Update a partner's infos
  public function updatePartnerInfos($pid, $address, $city, $email, $phone){

    $this->address = $address;
    $this->city = $city;
    $this->email = $email;
    $this->phone = $phone;
    $sql = "UPDATE partner SET address = :addr, city = :ct, email = :mail, phone = :phonenumb WHERE partner_id = :pid";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute(array(
      "addr" => $address,
      "ct" => $city,
      "mail" => $email,
      "phonenumb" => $phone,
      "pid" => $pid,
    ));
  }

  // -----------------------
  // Delete Partner
  public function delete(){
    $sql = "DELETE FROM partner WHERE partner_id = ?";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute([$this->partner_id]);
  }


  // ------------------------
  // Get all roles
  public function getAllRoles() {
    $sql = "SELECT * FROM role";
    $req = $GLOBALS["conn"]->prepare($sql);
    $req->execute();

    $result = array();

    while ($row = $req->fetch()) {
      $result[] = $row;
    }

    return $result;
  }


  // --------------------
  // Generate pdf contract
  public function generateContract($partner_id, $beginning_date, $end_date, $clauses) {
      $pdf = new Contract();
      $file_name = "contract-" . $partner_id . "-" . date("Y-m-d-H-i-s");
      $destination = $_SERVER['DOCUMENT_ROOT']. "/collaborateur/contracts/" . $file_name;


      $pdf->AddPage();
      $pdf->Ln(10);
      $pdf->SetFont('Arial','B',16);
      $pdf->Cell(40,10,'Hello World!');
      $pdf->Ln(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(40,10, 'Partner ID : ' . $partner_id);
      $pdf->Ln(10);
      $pdf->Cell(40,10, 'Starting Date : ' . $beginning_date);
      $pdf->Ln(10);
      $pdf->Cell(40,10, 'Ending Date : ' . $end_date);
      $pdf->Ln(10);
      $pdf->Cell(40,10, 'Clauses : ');
      $pdf->Ln(10);
      $pdf->MultiCell(0,5,$clauses);
      $pdf->Output('F', $destination, true);

      $sql = "INSERT INTO contract(beginning, end_date, clauses, partner_id, file_path) VALUES(:beginning, :end_date, :clauses, :pid, :filepath)";
      $req = $GLOBALS["conn"]->prepare($sql);
      $req->execute(array(
         "beginning" => $beginning_date,
         "end_date" => $end_date,
         "clauses" => $clauses,
         "pid" => $partner_id,
         "filepath" => $destination,
      ));

  }

  public function getContract() {

      $sql = "SELECT file_path FROM contract WHERE partner_id = ?";
      $req = $GLOBALS["conn"]->prepare($sql);
      $req->execute([$this->partner_id]);

      $result = $req->fetch();

      return $result["file_path"];
  }


}




?>

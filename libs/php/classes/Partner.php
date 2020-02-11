<?php

class Partner extends User {

  private int $partner_id;
  private string $corp_name;
  private string $corp_id;
  private int $role_id;
  private string $qrcode;
  private double $pricing;
  private $disponibility_begin;
  private $disponibility_end;

  function __construct($firstname, $lastname, $email, $password, $phone, $address, $city, $corp_name, $corp_id, $role_id, $qrcode, $pricing, $disponibility_begin, $disponibility_end) {
    parent::__construct($firstname, $lastname, $email, $password, $phone, $address, $city);
    $this->corp_name = $corp_name;
    $this->corp_id = $corp_id;
    $this->role_id = $role_id;
    $this->qrcode = $qrcode;
    $this->pricing = $pricing;
    $this->disponibility_begin = $disponibility_begin;
    $this->disponibility_end = $disponibility_end;
  }

  // Getters
  public function getCorpName(){
    return $this->corp_name;
  }

  public function getCorpId(){
    return $this->corp_id;
  }

  public function getRole(){
    return $this->role_id;
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

  // Setters
  public function setCorpName($name){
    $this->corp_name = $name;
  }

  public function setCorpId($id){
    $this->corp_id = $id;
  }

  public function setRole($id){
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
}


?>

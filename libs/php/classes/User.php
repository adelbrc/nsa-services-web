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
	public function signup($cus_id, $fname, $lname, $email, $pass, $phone, $addr, $city) {

		$sql = "INSERT INTO user(cus_id, firstname, lastname, email, password, phone_number, address, city)
		VALUES(:cus_id, :fname, :lname, :email, :pass, :phone, :addr, :city)";
		$req = $GLOBALS['conn']->prepare($sql);
		$req->execute(array(
			"cus_id" => $cus_id,
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
	public static function loadUser(string $email){

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

	public function generateMemberShipInvoice(Membership $membership) {
			$pdf = new Invoice();
			$file_name = "invoice-" . $this->id . "-" . $membership->getIdPlan() . "-" . date("Y-m-d-H-i-s");
			$destination = "admin/docs/invoices/" . $file_name . ".pdf";


			$pdf->AddPage();
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(40,10,'Thank you for your purchase');
			$pdf->Ln(10);
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(40,10, 'Date of issue : ' . date("d-m-Y"));
			$pdf->Ln(10);
			$pdf->Cell(40,10, 'Customer ID : ' . $this->id);
			$pdf->Ln(10);
			$pdf->Cell(40,10, 'Customer Email : ' . $this->email);
			$pdf->Ln(10);
			$pdf->Cell(40,10, 'Starting Date : ' . $this->getUserMembershipStartingDate($membership->getId()));
			$pdf->Ln(10);
			$pdf->Cell(40,10, 'Ending Date : ' . $this->getUserMembershipStartingDate($membership->getId()));
			$pdf->Ln(10);
			$pdf->Cell(40,10, 'Price : ' . $membership->getPrice());
			$pdf->Ln(10);
			$pdf->Cell(40,10, 'Description : ');
			$pdf->Ln(10);
			$pdf->MultiCell(0,5, $membership->getDescription());
			$pdf->Output('F', $destination, true);

			$sql = "INSERT INTO invoice(customer_id, amount_paid, date_issue, membership_id, file_path) VALUES (:cid, :pr, :di, :mid, :fp)";
			$req = $GLOBALS["conn"]->prepare($sql);
			$req->execute(array(
				"cid" => $this->id,
				"pr" => $membership->getPrice(),
				"di" => date("Y-m-d-H-i-s"),
				"mid" => $membership->getId(),
				"fp" => $destination,
			));

	}

	public function generateServiceInvoice(Service $service) {
		$pdf = new Invoice();
		$file_name = "invoice-" . $service->getId() . "-" . date("Y-m-d-H-i-s");
		$destination = "admin/docs/invoices/" . $file_name . ".pdf";


		$pdf->AddPage();
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Hello World!');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(40,10, 'Date of issue : ' . date("d-m-Y"));
		$pdf->Ln(10);
		$pdf->Cell(40,10, 'Customer ID : ' . $this->id);
		$pdf->Ln(10);
		$pdf->Cell(40,10, 'Customer Email : ' . $this->email);
		$pdf->Ln(10);
		$pdf->Cell(40,10, 'Prestation : ' . $service->getName());
		$pdf->Ln(10);
		$pdf->Cell(40,10, 'Price : ' . $service->getPrice());
		$pdf->Ln(10);
		$pdf->Cell(40,10, 'Description :');
		$pdf->Ln(10);
		$pdf->MultiCell(0,5,$service->getDescription());
		$pdf->Output('F', $destination, true);

	}

	// --------------------------------
	// Get Customer's membership starting date

	public function getUserMembershipStartingDate($membership_id) {
		$sql = "SELECT beginning FROM memberships_history WHERE user_id = :uid AND membership_id = :mid AND status = :st";
		$req = $GLOBALS["conn"]->prepare($sql);
		$req->execute(array(
			"uid" => $this->id,
			"mid" => $membership_id,
			"st" => "active",
		));
	}

}


?>

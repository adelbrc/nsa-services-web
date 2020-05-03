<?php

/**
 *
 */
class Order {

	private $order_id;
	private $customer_id;
	private $order_date;
	private $service_id;
	private $address;
	private $payment_status;

	function __construct($order_id, $customer_id, $order_date, $service_id, $address, $payment_status) {
		$this->order_id = $order_id;
		$this->customer_id = $customer_id;
		$this->order_date = $order_date;
		$this->service_id = $service_id;
		$this->address = $address;
		$this->payment_status = $payment_status;
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

	public function getServiceId(){
		return $this->service_id;
	}

	public function getAddress() {
		return $this->address;
	}

	public function getPaymentStatus(){
		return $this->payment_status;
	}

	// ----------------------
	// Methods

	// Add new order
	public static function addOrder() {

			$sql = "INSERT INTO nsaservices_db.orders(customer_id, order_date, service_id,
					address, payment_status) VALUES(:cid, :odate, :sid,
					:addr, :paystatus)";

			$req = $GLOBALS["conn"]->prepare($sql);
			$req->execute(array(
				"cid" => $this->customer_id,
				"odate" => $this->order_date,
				"sid" => $this->service_id,
				"addr" => $this->address,
				"paystatus" => $this->payment_status
			));
	}

	// Get an order by ID
	public function getOrderByID($id){

		$sql = "SELECT * FROM nsaservices_db.orders WHERE order_id = ?";
		$req = $GLOBALS["conn"]->prepare($sql);
		$req->execute([$id]);

		if ($row = $req->fetch()) {
			return new Order($row["order_id"], $row["customer_id"], $row["order_date"], $row["service_id"], $row["address"], $row["payment_status"]);
		}else {
			return NULL;
		}
	}

	// Get user's orders
	public static function getUserOrders($uid) {

		$sql = "SELECT * FROM nsaservices_db.orders WHERE customer_id = ?";
		$req = $GLOBALS["conn"]->prepare($sql);
		$req->execute([$uid]);

		$result = array();

		while ($row = $req->fetch()) {
			$result[] = new Order($row["order_id"], $row["customer_id"], $row["order_date"], $row["service_id"], $row["address"], $row["payment_status"]);
		}

		return $result;
	}

	// List all orders
	public static function getAllOrders(){

		$sql = "SELECT * FROM nsaservices_db.orders ORDER BY order_date DESC";
		$req = $GLOBALS["conn"]->prepare($sql);
		$req->execute();

		$result = array();

		while ($row = $req->fetch()) {
			$result[] = new Order($row["order_id"], $row["customer_id"], $row["order_date"], $row["service_id"], $row["address"], $row["payment_status"]);
		}

		return $result;
	}


	// Cancel an order
	public function cancel(){

		$sql = "UPDATE nsaservices_db.orders SET payment_status = ? WHERE order_id = ?";
		$req = $GLOBALS["conn"]->prepare($sql);
		$req->execute(["Canceled", $this->order_id]);
	}
}


?>

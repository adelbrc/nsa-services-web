<?php

require_once("DBManager.php");

$conn = DBManager::getConn();

/**
 *
 */
class Membership {

    private $id;
    private $id_plan;
    private $name;
    private $price;
    private $time_quota;
    private $open_days;
    private $open_hours;
    private $close_hours;
    private $description;
    private $duration;


    /**
     * Membership constructor.
     * @param $id
     * @param $id_plan
     * @param $name
     * @param $price
     * @param $time_quota
     * @param $open_days
     * @param $open_hours
     * @param $close_hours
     * @param $description
     * @param $duration
     */
     
    public function __construct($id, $id_plan, $name, $price, $time_quota, $open_days, $open_hours, $close_hours, $description, $duration)
    {
        $this->id = $id;
        $this->id_plan = $id_plan;
        $this->name = $name;
        $this->price = $price;
        $this->time_quota = $time_quota;
        $this->open_days = $open_days;
        $this->open_hours = $open_hours;
        $this->close_hours = $close_hours;
        $this->description = $description;
        $this->duration = $duration;
    }

    // Getters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdPlan()
    {
        return $this->id_plan;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getTimeQuota()
    {
        return $this->time_quota;
    }

    /**
     * @return mixed
     */
    public function getOpenDays()
    {
        return $this->open_days;
    }

    /**
     * @return mixed
     */
    public function getOpenHours()
    {
        return $this->open_hours;
    }

    /**
     * @return mixed
     */
    public function getCloseHours()
    {
        return $this->close_hours;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    // -----------------
    // Methods

    // Insert a membership in database
    public function addMembership(){
        $sql = "INSERT INTO membership(name, price, timeQuota, openDays, openHours, closeHours, description, duration) VALUES(:n, :p, :timeq, :od, :oh, :ch, :descr, :dur)";
        $req = $GLOBALS["conn"]->prepare($sql);
        $req->execute(array(
            "n" => $this->name,
            "p" => $this->price,
            "timeq" => $this->time_quota,
            "od" => $this->open_days,
            "oh" => $this->open_hours,
            "ch" => $this->close_hours,
            "decr" => $this->description,
            "dur" => $this->duration,
        ));
    }

    // Get membership by ID
    public static function getMembershipById($id){
        $sql = "SELECT * FROM membership WHERE id = ?";
        $req = $GLOBALS["conn"]->prepare($sql);
        $req->execute([$id]);

        if ($row = $req->fetch()) {
            return new Membership($row["id"], $row["id_plan"], $row["name"], $row["price"], $row["timeQuota"],
                $row["openDays"], $row["openHours"], $row["closeHours"], $row["description"], $row["duration"]);
        }else {
            return NULL;
        }
    }

    // Get membership by Stripe Plan ID
    public static function getMembershipByStripeId($id){
        $sql = "SELECT * FROM membership WHERE id_plan = ?";
        $req = $GLOBALS["conn"]->prepare($sql);
        $req->execute([$id]);

        if ($row = $req->fetch()) {
            return new Membership($row["id"], $row["id_plan"], $row["name"], $row["price"], $row["timeQuota"],
                $row["openDays"], $row["openHours"], $row["closeHours"], $row["description"], $row["duration"]);
        }else {
            return NULL;
        }
    }

}


?>

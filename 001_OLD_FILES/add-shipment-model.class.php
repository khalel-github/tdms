<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once "../config.php";

class AddShipmentModel
{
    private $shipmentNumberAdd;
    private $startingPointAdd;
    private $destinationAdd;
    private $dateOfDeliveryAdd;
    private $clientAdd;
    private $areaRateAdd;
    private $vehicleAdd;


    public function __construct(
        $shipmentNumberAdd,
        $startingPointAdd,
        $destinationAdd,
        $dateOfDeliveryAdd,
        $clientAdd,
        $areaRateAdd,
        $vehicleAdd
    ) {

        $this->shipmentNumberAdd = $shipmentNumberAdd;
        $this->startingPointAdd = $startingPointAdd;
        $this->destinationAdd = $destinationAdd;
        $this->dateOfDeliveryAdd = $dateOfDeliveryAdd;
        $this->clientAdd = $clientAdd;
        $this->areaRateAdd = $areaRateAdd;
        $this->vehicleAdd = $vehicleAdd;
    }

    public function addShipmentRecord()
    {
        /*
        if($this->emptyValidator() == false || $this->lengthValidator() == false || $this->patternValidator() == false ){
            session_start();
            $_SESSION['prompt'] = "The information you entered are not valid!";
            header('location: ../modal-prompt.php');
            exit();
        }

        if($this->shipmentNumberValidator() == false){
            
            $_SESSION['prompt'] = "A record with the same shipment number exists in the system! A different company might be using the same shipment number.";
            header('location: ../modal-prompt.php');
            exit();
        }

        if($this->vehiclePlateNumberValidator() == false){
            
            $_SESSION['prompt'] = "The vehicle plate number you entered is not registered in the system!";
            header('location: ../modal-prompt.php');
            exit();
        }
*/
        $this->addShipmentSubmit();
    }

    public function addShipmentSubmit()
    {

        $sql = "INSERT INTO 
                shipment(
                shipment_number, 
                shipment_status, 
                starting_point,
                destination,
                date_of_delivery,
                area_id,
                vehicle_id
                ) 
                VALUES( 
                :shipment_number, 
                :shipment_status, 
                :starting_point,
                :destination,
                :date_of_delivery,
                :area_id,
                :vehicle_id
                )";

        $configObj = new Config();

        $pdoVessel = $configObj->pdoConnect();

        if ($stmt = $pdoVessel->prepare($sql)) {

            $stmt->bindParam(":shipment_number", $paramShipmentNumberAdd, PDO::PARAM_STR);
            $stmt->bindParam(":shipment_status", $paramShipmentStatusAdd, PDO::PARAM_STR);
            $stmt->bindParam(":starting_point", $paramStartingPointAdd, PDO::PARAM_STR);
            $stmt->bindParam(":destination", $paramDestinationAdd, PDO::PARAM_STR);
            $stmt->bindParam(":date_of_delivery", $paramDateOfDeliveryAdd, PDO::PARAM_STR);
            $stmt->bindParam(":area_id", $paramAreaIdAdd, PDO::PARAM_STR);
            $stmt->bindParam(":vehicle_id", $paramVehicleIdAdd, PDO::PARAM_STR);

            $paramShipmentNumberAdd = $this->shipmentNumberAdd;
            $paramShipmentStatusAdd = $this->shipmentStatusAdd;
            $paramStartingPointAdd = $this->startingPointAdd;
            $paramDestinationAdd = $this->destinationAdd;
            $paramDateOfDeliveryAdd = $this->dateOfDeliveryAdd;
            $paramAreaIdAdd = $this->areaRateAdd;
            $paramVehicleIdAdd = $this->vehicleAdd;

            if ($stmt->execute()) {
                echo "Successfully added a record!";
            } else {

                $_SESSION["prompt"] = "Something went wrong!";
                header('location: ../modal-prompt.php');
                exit();
            }


            unset($stmt);
        }
        unset($pdoVessel);
    }

    private function emptyValidator()
    {
        if (
            empty(trim($this->shipmentNumberAdd)) ||
            empty(trim($this->shipmentStatusAdd)) ||
            empty(trim($this->startingPointAdd)) ||
            empty(trim($this->destinationAdd)) ||
            empty(trim($this->callTimeAdd)) ||
            empty(trim($this->dateOfDeliveryAdd)) ||
            empty(trim($this->vehiclePlateNumberAdd))
        ) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function lengthValidator()
    {
        if (
            strlen(trim($this->shipmentNumberAdd)) < 1 && strlen(trim($this->shipmentNumberAdd)) > 255 &&
            strlen(trim($this->startingPointAdd)) < 1 && strlen(trim($this->startingPointAdd)) > 255 &&
            strlen(trim($this->destinationAdd)) < 1 && strlen(trim($this->destinationAdd)) > 255 &&
            strlen(trim($this->vehiclePlateNumberAdd)) < 1 && strlen(trim($this->vehiclePlateNumberAdd)) > 255
        ) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function patternValidator()
    {
        if (
            !preg_match('/^[0-9]+$/', trim($this->shipmentNumberAdd)) ||
            !preg_match('/^[a-zA-Z0-9\s]+$/', trim($this->startingPointAdd)) ||
            !preg_match('/^[a-zA-Z0-9\s]+$/', trim($this->destinationAdd)) ||
            !preg_match('/^[a-zA-Z0-9]+$/', trim($this->vehiclePlateNumberAdd))
        ) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public function shipmentNumberValidator()
    {
        $configObj = new Config();

        $pdoVessel = $configObj->pdoConnect();

        $sql = "SELECT * FROM shipment WHERE shipmentNumber = :shipmentNumber AND companyName = :companyName";

        if ($stmt = $pdoVessel->prepare($sql)) {

            $stmt->bindParam(":shipmentNumber", $paramShipmentNumber, PDO::PARAM_STR);
            $stmt->bindParam(":companyName", $paramCompanyName, PDO::PARAM_STR);

            $paramShipmentNumber = $this->shipmentNumberAdd;
            $paramCompanyName = $this->companyName;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $result = false;
                } else {
                    $result = true;
                }
            } else {
                session_start();
                $_SESSION["prompt"] = "Something went wrong!";
                header('location: ../modal-prompt.php');
                exit();
            }

            unset($stmt);

            return $result;
        }
        unset($pdoVessel);
    }

    public function vehiclePlateNumberValidator()
    {
        $configObj = new Config();

        $pdoVessel = $configObj->pdoConnect();

        $sql = "SELECT * FROM vehicle WHERE vehiclePlateNumber = :vehiclePlateNumber AND companyName = :companyName";

        if ($stmt = $pdoVessel->prepare($sql)) {

            $stmt->bindParam(":vehiclePlateNumber", $paramVehiclePlateNumber, PDO::PARAM_STR);
            $stmt->bindParam(":companyName", $paramCompanyName, PDO::PARAM_STR);


            $paramVehiclePlateNumber = $this->vehiclePlateNumberAdd;
            $paramCompanyName = $this->companyName;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                session_start();
                $_SESSION["prompt"] = "Something went wrong!";
                header('location: ../modal-prompt.php');
                exit();
            }

            unset($stmt);

            return $result;
        }
        unset($pdoVessel);
    }
}

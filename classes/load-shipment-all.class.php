<?php
//PART OF NEW SYSTEM

if (!isset($_SESSION)) {
    session_start();
}
require_once "../config.php";

$tabValue = $_POST["tabValue"];
$currentPageNumber = $_POST["currentPageNumber"];
$orderBy = $_POST["orderBy"];

//$test = 2;
$startingLimitNumber = ($currentPageNumber - 1) * 4;

//echo $startingLimitNumber;


try {
    $configObj = new Config();
    $pdoVessel = $configObj->pdoConnect();

    switch ($tabValue) {
        case "All":
            $sql = "SELECT 
            shipment.shipment_id,
            shipment.shipment_number,
            shipment.shipment_status,
            shipment.shipment_description,
            shipment.destination,
            shipment.date_of_delivery,
            client.client_name,
            vehicle.plate_number,
            shipment.vehicle_id,
            shipment.area_id
            FROM shipment
            INNER JOIN clientarea
            ON shipment.area_id = clientarea.area_id
            INNER JOIN client
            ON clientarea.client_id = client.client_id
            INNER JOIN vehicle
            ON shipment.vehicle_id = shipment.vehicle_id
            WHERE client.company_id = :company_id
            ORDER BY " . $orderBy . " LIMIT " . $startingLimitNumber . ',' . '4';
            break;
        case "In-progress":
            $sql = "SELECT 
            shipment.shipment_id,
            shipment.shipment_number,
            shipment.shipment_status,
            shipment.shipment_description,
            shipment.destination,
            shipment.date_of_delivery,
            client.client_name,
            vehicle.plate_number,
            shipment.vehicle_id,
            shipment.area_id
            FROM shipment
            INNER JOIN clientarea
            ON shipment.area_id = clientarea.area_id
            INNER JOIN client
            ON clientarea.client_id = client.client_id
            INNER JOIN vehicle
            ON shipment.vehicle_id = shipment.vehicle_id
            WHERE client.company_id = :company_id
            AND shipment.shipment_status = 'In-progress' 
            ORDER BY " . $orderBy . " LIMIT " . $startingLimitNumber . ',' . '4';
            break;
        case "Completed":
            $sql = "SELECT 
            shipment.shipment_id,
            shipment.shipment_number,
            shipment.shipment_status,
            shipment.shipment_description,
            shipment.destination,
            shipment.date_of_delivery,
            client.client_name,
            vehicle.plate_number,
            shipment.vehicle_id,
            shipment.area_id
            FROM shipment
            INNER JOIN clientarea
            ON shipment.area_id = clientarea.area_id
            INNER JOIN client
            ON clientarea.client_id = client.client_id
            INNER JOIN vehicle
            ON shipment.vehicle_id = shipment.vehicle_id
            WHERE client.company_id = :company_id
            AND shipment.shipment_status = 'Completed' 
            ORDER BY " . $orderBy . " LIMIT " . $startingLimitNumber . ',' . '4';
            break;
        case "Cancelled":
            $sql = "SELECT 
            shipment.shipment_id,
            shipment.shipment_number,
            shipment.shipment_status,
            shipment.shipment_description,
            shipment.destination,
            shipment.date_of_delivery,
            client.client_name,
            vehicle.plate_number,
            shipment.vehicle_id,
            shipment.area_id
            FROM shipment
            INNER JOIN clientarea
            ON shipment.area_id = clientarea.area_id
            INNER JOIN client
            ON clientarea.client_id = client.client_id
            INNER JOIN vehicle
            ON shipment.vehicle_id = shipment.vehicle_id
            WHERE client.company_id = :company_id
            AND shipment.shipment_status = 'Cancelled' 
            ORDER BY " . $orderBy . " LIMIT " . $startingLimitNumber . ',' . '4';
            break;
    }
    /*
    $sql = "SELECT 
    shipment.shipment_id,
    shipment.shipment_number,
    shipment.shipment_status,
    shipment.starting_point,
    shipment.destination,
    shipment.date_of_delivery,
    client.client_name,
    vehicle.plate_number
    FROM shipment
    INNER JOIN clientarea
    ON shipment.area_id = clientarea.area_id
    INNER JOIN client
    ON clientarea.client_id = client.client_id
    INNER JOIN vehicle
    ON shipment.vehicle_id = shipment.vehicle_id
    WHERE client.company_id = :company_id
    ORDER BY " . $orderBy . " LIMIT " . $startingLimitNumber . ',' . '4';*/

    $stmt = $pdoVessel->prepare($sql);

    $stmt->bindParam(":company_id", $paramCompanyId, PDO::PARAM_STR);

    $paramCompanyId = $_SESSION["companyId"];

    $stmt->execute();
    $row = $stmt->fetchAll();
    $json = json_encode($row);

    echo $json;
} catch (Exception $ex) {
    session_start();
    $_SESSION['prompt'] = "Something went wrong!";
    header('location: ../prompt.php');
    exit();
}

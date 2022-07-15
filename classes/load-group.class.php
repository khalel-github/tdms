<?php
//PART OF NEW SYSTEM

if (!isset($_SESSION)) {
    session_start();
}
require_once "../config.php";


$currentPageNumber = $_POST["currentPageNumber"];
$orderBy = $_POST["orderBy"];

//$test = 2;
$startingLimitNumber = ($currentPageNumber - 1) * 4;

//echo $startingLimitNumber;


try {
    $configObj = new Config();
    $pdoVessel = $configObj->pdoConnect();

    $sql = "SELECT
    subcontractor.subcontractor_id,
    subcontractor.username,
    subcontractor.first_name, 
    subcontractor.middle_name, 
    subcontractor.last_name,
    ownergroup.group_id,
    ownergroup.group_name 
    FROM subcontractor
    INNER JOIN ownergroup 
    ON subcontractor.subcontractor_id = ownergroup.owner_id 
    WHERE subcontractor.company_id = :company_id 
    ORDER BY " . $orderBy . " LIMIT ". $startingLimitNumber . ',' . '4';

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

<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config.php";


class LoginModel
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {

        $this->username = $username;
        $this->password = $password;
    }

    public function login()
    {

        $this->loginSubmit();
        $this->getPermission();
        header("location: ../dashboard.php");
    }

    private function loginSubmit()
    {

        $configObj = new Config();
        $pdoVessel = $configObj->pdoConnect();

        $sql = "SELECT
        user_id,
        user_name, 
        password,
        first_name,
        middle_name,
        last_name,
        permission_id 
        FROM user
        WHERE user_name = :user_name";

        if ($stmt = $pdoVessel->prepare($sql)) {

            $stmt->bindParam(":user_name", $paramUsername, PDO::PARAM_STR);

            $paramUsername = trim($this->username);

            if ($stmt->execute()) {

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {

                        $userId = $row["user_id"];
                        $username = $row["user_name"];
                        $firstName = $row["first_name"];
                        $middleName = $row["middle_name"];
                        $lastName = $row["last_name"];
                        $permissionId = $row["permission_id"];
                        $hashedPassword = $row["password"];

                        if (password_verify($this->password, $hashedPassword)) {


                            $_SESSION["loggedin"] = true;
                            $_SESSION["userId"] = $userId;
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $hashedPassword;
                            $_SESSION["firstName"] = $firstName;
                            $_SESSION["middleName"] = $middleName;
                            $_SESSION["lastName"] = $lastName;
                            $_SESSION["permissionId"] = $permissionId;
                            //$_SESSION["shipmentAccess"] = 'Yes';

                            //$this->getPermission();
                            header("location: ../session_variable_test.php");
                        } else {

                            $_SESSION["prompt"] = "Invalid username or password!";
                            header('location: ../prompt.php');
                            exit();
                        }
                    }
                } else {

                    $_SESSION["prompt"] = "Invalid username or password!";
                    header('location: ../prompt.php');
                    exit();
                }
            } else {

                $_SESSION["prompt"] = "Something went wrong!";
                header('location: ../prompt.php');
                exit();
            }
            unset($stmt);
        }
        unset($pdoVessel);
    }

    private function getPermission()
    {

        $configObj = new Config();
        $pdoVessel = $configObj->pdoConnect();

        $sql = "SELECT * FROM permission WHERE permission_id = :permission_id";

        if ($stmt = $pdoVessel->prepare($sql)) {

            $stmt->bindParam(":permission_id", $paramPermissionId, PDO::PARAM_STR);

            $paramPermissionId = $_SESSION["permissionId"];

            if ($stmt->execute()) {

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {

                        $roleName = $row["role_name"];
                        $accountType = $row["account_type"];
                        $dashboardAccess = $row["dashboard_access"];
                        $shipmentAccess = $row["shipment_access"];
                        $employeeAccess = $row["employee_access"];
                        $subcontractorAccess = $row["subcontractor_access"];
                        $companyId = $row["company_id"];

                        $_SESSION["roleName"] = $roleName;
                        $_SESSION["accountType"] = $accountType;
                        $_SESSION["dashboardAccess"] = $dashboardAccess;
                        $_SESSION["shipmentAccess"] = $shipmentAccess;
                        $_SESSION["employeeAccess"] = $employeeAccess;
                        $_SESSION["subcontractorAccess"] = $subcontractorAccess;
                        $_SESSION["companyId"] = $companyId;

                    }
                }
            } else {

                $_SESSION["prompt"] = "Something went wrong!";
                header('location: ../prompt.php');
                exit();
            }
            unset($stmt);
        }
        unset($pdoVessel);
    }


    private function emptyValidator()
    {
        if (empty(trim($this->username)) || empty(trim($this->password))) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}

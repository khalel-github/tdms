
<?php
//PART OF NEW SYSTEM
include 'sign-up-user-model.class.php';

if (isset($_POST["submitAddForm"])) {

    $usernameAdd = $_POST['usernameAdd'];
    $passwordAdd = $_POST['passwordAdd'];
    $firstNameAdd = $_POST['firstNameAdd'];
    $middleNameAdd = $_POST['middleNameAdd'];
    $lastNameAdd = $_POST['lastNameAdd'];
    $companyId = $_POST["companyNameSelect"];

    $addObj = new AddUserModel(
        $usernameAdd,
        $passwordAdd,
        $firstNameAdd,
        $middleNameAdd,
        $lastNameAdd,
        $companyId
    );

    $addObj->addUserRecord();
    

    //echo $companyId;
}

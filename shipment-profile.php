<?php
//SESSION START
if (!isset($_SESSION)) {
    session_start();
}
/*
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["shipmentAccess"] === 'No') {
  header("location: dashboard-default.php");
  exit;
}*/

include_once 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Profile</title>

    <!--JQUERY CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <!--AJAX CDN-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--BULMA CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!--FONTAWESOME CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!--NAVBAR CSS-->
    <link rel="stylesheet" href="navbar.css">

    <!--INTERNAL CSS-->
    <style>
        .progressbar {
            counter-reset: step;
        }

        .progressbar li {
            list-style-type: none;
            width: 25%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: white;
        }

        .progressbar li:before {
            width: 30px;
            height: 30px;
            content: '✖';
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: #7d7d7d;
        }

        .progressbar li:after {
            width: 100%;
            height: 5px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {
            color: white;

        }

        .progressbar li.active:before {
            background-color: #55b776;
            border-color: #55b776;
            content: '✔';

        }

        .progressbar li.active+li:after {
            background-color: #55b776;
        }

        .progressbar li.transfer {
            color: black;

        }

        .progressbar li.transfer:before {
            background-color: red;
            border-color: red;
            content: '!';

        }

        .progressbar li.transfer+li:after {
            background-color: red;
        }

        @media (min-width: 1000px) {

            #shipmentTitle {
                float: right;
                padding-right: 100px;
            }

            .firstContainer {
                border-bottom: 1px solid gray;
            }
        }

        @media (max-width: 1000px) {
            #shipmentTitle {
                margin-bottom: 50px;
            }

            .verticalContainer {
                margin-top: 150px;
            }
        }

        .left-td {
            float: right;
        }

        /*BREAK*/
        /*
        .verticalContainer {
            padding: 20px 40px; 
            font-size: 14px;
        }
*/
        .verticalContainer ul {
            position: relative;
            list-style: none;
            padding: 0;
        }

        .verticalContainer ul:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            background-color: #ddd;
            width: 3px;
            height: 100%;
        }

        .verticalContainer ul li {
            padding: 30px 30px;
            position: relative;
        }

        .selected div {
            color: tomato;
        }

        .verticalContainer li span {
            position: absolute;
            left: -45px;
            font-size: 12px;
            background-color: #fff;
            padding: 10px 0;
            top: 20px;
            color: #aaa;
        }

        .verticalContainer li div {
            margin-left: 50px;
        }
    </style>
</head>

<body>
    <div class="main" style="margin-bottom: 20%;">
        <div class="container firstContainer" style="margin-bottom: 5%;">
            <button class="button is-rounded mb-5 is-light" id="returnBtn"><i class="fa-solid fa-arrow-left mr-3"></i>Return</button>
            <button class="button is-rounded mb-5 is-light" id="transferBtn"><i class="fa-solid fa-cart-flatbed mr-3"></i>Transfer</button>
            <button class="button is-rounded mb-5 is-light" id="cancelBtn"><i class="fa-solid fa-ban mr-3"></i>Cancel</button>
            <p class="title is-4" id="shipmentTitle">Shipment <i class="fa-solid fa-hashtag"></i><?php echo "" . $_SESSION["shipmentNumber"] ?></p>
            <p class="title is-4 is-hidden" id="shipmentTitleHidden"><?php echo $_SESSION["shipmentId"] ?></p>
            <p class="title is-4 is-hidden" id="areaIdHidden"><?php echo $_SESSION["areaId"] ?></p>
            <p class="title is-4 is-hidden" id="vehicleIdHidden"><?php echo $_SESSION["vehicleId"] ?></p>
            <p class="title is-4 is-hidden" id="shipmentStatusHidden"><?php echo $_SESSION["shipmentStatus"] ?></p>
            <p class="title is-4 is-hidden" id="indicatorHidden">result here</p>
        </div>
        <!-- DESCRIPTION -->
        <div class="container" style="padding: 50px;">
            <p class="title is-5 mb-6" id="shipmentDescriptionTitle">Shipment Description:</p>
            <p class="subtitle is-6" id="shipmentDescriptionSubtitle" style="margin-bottom: 100px;"><?php echo $_SESSION["shipmentDescription"] ?> Lorem ipsum dolor sit amet consectetur adipisicing elit. Et blanditiis illum velit doloribus fuga nemo inventore consequatur eveniet, earum ab totam, est magnam? Quidem, odit. Quam omnis aliquam ipsa laborum. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Temporibus beatae natus quaerat recusandae exercitationem. Obcaecati error dignissimos temporibus est alias itaque doloribus aperiam. Facilis repellendus dolore quae saepe quod delectus.</p>
        </div>
        <!-- DESCRIPTION -->

        <!-- PROGRESS BAR + LOG -->
        <div class="container">
            <ul class="progressbar">
                <li class="active" id="shipmentPlacedId">
                    <p style="color: black;">Shipment Placed</p>
                </li>
                <li class="" id="shipmentPickupId">
                    <p style="color: black;">Shipment Pickup</p>
                </li>
                <li class="" id="shipmentDropoffId">
                    <p style="color: black;">Shipment Drop-off</p>
                </li>
                <li class="transfer" id="completedDeliveryId">
                    <p style="color: black;">Completed Delivery</p>
                </li>
            </ul>
        </div>
        <div class="container verticalContainer" style="padding: 10%;">
            <ul id="verticalContainerUl">
                <!--
                <li>
                    <span>2022-07-20 03:35</span>
                    <div>This is an update.</div>
                </li>
                <li>
                    <span>2022-07-20 03:35</span>
                    <div>This is an update.</div>
                </li>
                <li>
                    <span>2022-07-20 03:35</span>
                    <div>This is an update.</div>
                </li>
                <li>
                    <span>2022-07-20 03:35</span>
                    <div>This is an update.</div>
                </li>
                <li>
                    <span>2022-07-20 03:35</span>
                    <div>This is an update.</div>
                </li>
                <li>
                    <span>2022-07-20 03:35</span>
                    <div>This is an update.</div>
                </li>
                <li class="selected">
                    <span>2022-07-20 03:35</span>
                    <div>This is the latest update.</div>
                </li>-->
    
            </ul>
        </div>
        <!-- PROGRESS BAR + LOG -->



        <!-- DETAILS ******************************* USE TILES WITH THREE COLUMNS ****************************** -->
        <div class="container" style="padding-left: 50px; padding-right: 50px">
            <div class="tile is-ancestor">
                <div class="tile is-parent">
                    <div class="tile is-child">
                        <p class="title is-5 mb-6">Expected Date of Delivery:</p>
                        <p class="subtitle is-6" id="dateOfDeliverySubtitle" style="margin-bottom: 75px;"><?php echo $_SESSION["dateOfDelivery"] ?></p>
                        <p class="title is-5 mb-6">Destination:</p>
                        <p class="subtitle is-6" id="destinationSubtitle" style="margin-bottom: 75px;"><?php echo $_SESSION["destination"] ?></p>
                        <p class="title is-5 mb-6">Client:</p>
                        <p class="subtitle is-6" id="clientNameSubtitle" style="margin-bottom: 75px;"><?php echo $_SESSION["clientName"] ?></p>

                    </div>
                    <div class="tile is-child">
                        <p class="title is-5 mb-6">Personnel:</p>
                        <p class="subtitle is-6" id="driverSubtitle"></p>
                        <p class="subtitle is-6" id="helperSubtitle"></p>
                        <p class="subtitle is-6" id="plateNumberSubtitle" style="margin-bottom: 75px;"></p>
                    </div>
                </div>
            </div>

        </div>
        <!-- DETAILS ******************************* USE TILES WITH THREE COLUMNS ****************************** -->


    </div>
</body>

<!--EXTERNAL JAVASCRIPT-->
<script src="js/shipment-profile.js"></script>


<!--INTERNAL JAVASCRIPT-->
<script>
    logoutBtn.classList.remove("is-hidden");
    shipmentBtn.classList.add("is-active");
</script>

</html>
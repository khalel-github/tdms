<?php
//PART OF NEW SYSTEM
include_once 'navbar.php';

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Company Sign-up</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="navbar.css">
  <style>

  </style>
</head>

<body>
<div class="main_alt">
  <div class="section">
    <div class="container">
      <form id="signUpCompanyForm" action="classes/sign-up-company-controller.class.php" class="box has-background-white-ter" method="POST">

        <h3 class="title is-3"> <i class="fas fa-user-cog mr-3"></i> Company Admin Account</h3>

        <div class="field">
          <label for="" class="label">Username</label>
          <div class="control has-icons-left">
            <input type="text" placeholder="Enter username here" class="input is-rounded" name="username" id="username">
            <span class="icon is-small is-left">
              <i class="fas fa-user"></i>
            </span>
          </div>
          <p class="help" id="usernameHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Password</label>
          <div class="control has-icons-left">
            <input type="password" placeholder="Enter password here" class="input is-rounded" name="password" id="password">
            <span class="icon is-small is-left">
              <i class="fa fa-lock"></i>
            </span>
          </div>
          <p class="help" id="passwordHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Confirm Password</label>
          <div class="control has-icons-left">
            <input type="password" placeholder="Enter password again here" class="input is-rounded" name="confirmPassword" id="confirmPassword">
            <span class="icon is-small is-left">
              <i class="fa fa-lock"></i>
            </span>
          </div>
          <p class="help" id="confirmPasswordHelp"></p>
        </div>

        <h3 class="title is-3 mt-6"> <i class="fas fa-building mr-3"></i>Company Information</h3>

        <div class="field">
          <label for="" class="label">Company Name</label>
          <div class="control has-icons-left">
            <input type="text" placeholder="Enter company name here" class="input is-rounded" name="companyName" id="companyName">
            <span class="icon is-small is-left">
              <i class="fas fa-id-badge"></i>
            </span>
          </div>
          <p class="help" id="companyNameHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Company Email</label>
          <div class="control has-icons-left">
            <input type="text" placeholder="Enter company email here" class="input is-rounded" name="companyEmail" id="companyEmail">
            <span class="icon is-small is-left">
              <i class="fas fa-envelope"></i>
            </span>
          </div>
          <p class="help" id="companyEmailHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Company Contact Number</label>
          <div class="control has-icons-left">
            <input type="text" placeholder="Enter company telephone here" class="input is-rounded" name="companyNumber" id="companyNumber">
            <span class="icon is-small is-left">
              <i class="fas fa-phone"></i>
            </span>
          </div>
          <p class="help" id="companyNumberHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Company Address (Unit/Floor + House/Building Name + Street Number + Street Name)</label>
          <div class="control has-icons-left">
            <input type="text" placeholder="Enter company address here" class="input is-rounded" name="companyAddress" id="companyAddress">
            <span class="icon is-small is-left">
              <i class="fas fa-map-marker-alt"></i>
            </span>
          </div>
          <p class="help" id="companyAddressHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Region</label>
          <div class="control">
            <div class="select is-rounded" id="regionDiv">
              <select id="region" name="region">
              </select>
            </div>
          </div>
          <p class="help" id="regionHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label"> Province</label>
          <div class="control">
            <div class="select is-rounded" id="provinceDiv">

              <select id="province" name="province">

              </select>
            </div>
          </div>
          <p class="help" id="provinceHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">City</label>
          <div class="control">
            <div class="select is-rounded" id="cityDiv">

              <select id="city" name="city">

              </select>
            </div>
          </div>
          <p class="help" id="cityHelp"></p>
        </div>

        <div class="field">
          <label for="" class="label">Barangay</label>
          <div class="control">
            <div class="select is-rounded" id="barangayDiv">
              <select id="barangay" name="barangay">

              </select>
            </div>
          </div>
          <p class="help" id="barangayHelp"></p>
        </div>

        <div class="field mt-5">
          <button class="button has-background-link has-text-white is-rounded" type="submit" name="submit" id="submitForm">
            <i class="fas fa-paper-plane mr-3"></i>Submit
          </button>
        </div>

      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="content has-text-centered">
      <p>
        <strong>Bulma</strong> by <a href="https://jgthms.com">Jeremy Thomas</a>. The source code is licensed
        <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
        is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
      </p>
    </div>
  </footer>
  </div>
</body>

<!--DO NOT AUTO FORMAT THIS CODE-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
        <!-- script type="text/javascript" src="../../jquery.ph-locations.js"></script -->
        <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script -->
        <script type="text/javascript">
            
            var my_handlers = {

                fill_provinces:  function(){

                    var region_code = $(this).val();
                    $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
                    
                },

                fill_cities: function(){

                    var province_code = $(this).val();
                    $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
                },


                fill_barangays: function(){

                    var city_code = $(this).val();
                    $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
                }
            };

            $(function(){
                $('#region').on('change', my_handlers.fill_provinces);
                $('#province').on('change', my_handlers.fill_cities);
                $('#city').on('change', my_handlers.fill_barangays);

                $('#region').ph_locations({'location_type': 'regions'});
                $('#province').ph_locations({'location_type': 'provinces'});
                $('#city').ph_locations({'location_type': 'cities'});
                $('#barangay').ph_locations({'location_type': 'barangays'});

                $('#region').ph_locations('fetch_list');
            });
        </script>
        <script>

  </script>
  <!--DO NOT AUTO FORMAT THIS CODE-->
  
<script src="js/sign-up-company.js"></script>

<script>
  let clientTrackingBtn = document.getElementById('clientTrackingBtn')

  let signupBtn = document.getElementById('signupBtn')
  let loginBtn = document.getElementById('loginBtn')
  let logoutBtn = document.getElementById('logoutBtn')

  if (<?php echo !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ?>) {

    clientTrackingBtn.classList.remove("is-hidden");

    signupBtn.classList.remove("is-hidden");
    loginBtn.classList.remove("is-hidden");
  }
  sidenav_class.style.display = "none";

  burger_2.classList.add("is-hidden");
</script>

</html>
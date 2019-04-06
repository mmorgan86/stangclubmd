<?php
require_once "config/config.php";
require_once "includes/formHandlers/registerHandler.php";
require_once "includes/formHandlers/loginHandler.php";

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>StangClubMD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap css -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- jQuery -->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

   <!-- custom style -->
   <link rel="stylesheet" href="assets/css/register_style.css">

   <!-- custom js -->
<script src="assets/js/register.js"></script>

</head>
<body>

<?php
if (isset($_POST['register_button'])) {
    echo '
      <script>
        $(document).ready(function() {
          $("#login_div").hide();
          $("#register_div").show();
        });
      </script>
    ';
}

?>

<div class="wrapper">
  <div class="login_box">
  <div class="login_header">
    <h2>Stang Club Maryland</h2>
    <p>Login or Sign up below!</p>
  </div>


  <!-- login form -->
  <div id="login_div">
  <form action="register.php" method="POST">
    <?php
if (in_array("<span class='text-danger'>Please enter the correct email and password!</span>", $error_array)) {
    echo "<span class='text-danger'>Please enter the correct email and password!</span><br>";
}
?>
    <!-- <input type="email" name="log_email" placeholder="Enter Email" value="
    <?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
}
?>
    " required
    > -->
    <input type="text" name="log_username" id="log_username" placeholder="Enter Username" value="<?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?>">
    <br>
    <input type="password" name="log_password" placeholder="Enter Password"><br>
    <input type="submit" name="login_button" value="Login"><br>
    <a href="#" id="signup" class="signup">Need an account? Register Here!</a>
  </form>
</div>


<!-- register form -->
<div id="register_div">
  <form class="text-center" action="register.php" method="POST">
    <input type="text" name="vehicle" placeholder="Enter Your Stang" value="<?php if(isset($_SESSION['reg_vehicle'])) echo $_SESSION['reg_vehicle']; ?>">
    <input type="text" name="reg_fname" placeholder="First Name"
      value="<?php if (isset($_SESSION['reg_fname'])) {
      echo $_SESSION['reg_fname'];}?>"
    required><br>
    <?php if (in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) {
      echo "<small class='text-danger'>Your first name must be between 2 and 25 characters</small><br>";}?>

    <input type="text" name="reg_lname" placeholder="Last Name"
      value="<?php if (isset($_SESSION['reg_lname'])) {
    echo $_SESSION['reg_lname'];}?>"
    required>
    <br>
    <?php if (in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) {
     echo "<small class='text-danger'>Your last name must be between 2 and 25 characters</small><br>";}?>

    <input type="email" name="reg_email" placeholder="Email"
    value="<?php if (isset($_SESSION['reg_email'])) {
    echo $_SESSION['reg_email'];}?>"required>
    <br>

    <input type="email" name="reg_email2" placeholder="Confirm Email"
    value="<?php if (isset($_SESSION['reg_email2'])) {
    echo $_SESSION['reg_email2'];}?>"required>
    <br>
      <?php if (in_array("Email already in use<br>", $error_array)) {
        echo "<small class='text-danger'>Email already in use</small><br>";
      } else if (in_array("Invalid format <br>", $error_array)) {
        echo "<small class='text-danger'>Invalid format</small><br>";
      } else if (in_array("Emails don't match<br>", $error_array)) {
        echo "<small class='text-danger'>Emails don't match</small><br>";}?>
        
    <!-- username -->
    <?php 
      if(in_array("Username is already in use", $error_array)) {
        echo "<small class='text-danger'>Username is already in use</small><br>";
      }
    ?>
    <input type="text" name="reg_username" id="reg_username" placeholder="Enter Username" value="<?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?>">
    <br>

    <input type="password" name="reg_password" placeholder="Password" required><br>
    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
    <br>

    <?php if (in_array("Your passwords do not match!<br>", $error_array)) {
      echo "<small class='text-danger'>Your passwords do not match!</small><br>";
    } else if (in_array("Your password can only contain english characters or  numbers<br>", $error_array)) {
      echo "<small class='text-danger'>Your password can only contain english characters or numbers</small><br>";
    } 
    else if (in_array("Your password must be between 5 and 30 characters<br>", $error_array)) {
      echo "<small class='text-danger'>Your password must be between 5 and 30 characters</small><br>";
    }?>
    
    <input type="submit" name="register_button" value="Register"><br>
    <?php
      if (in_array("<span class='text-success'>You're all set! Go ahead and login</span><br>", $error_array)) {
        echo "<span class='text-success'>You're all set! Go ahead and login</span><br>";
      }?>

    <a href="#" id="login" class="login">Already have an account? Login Here!</a>

  </form>

</div>
</div>



</body>
</html>

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
  <!-- BOOTSTRAP  -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- custom style -->
  <link rel="stylesheet" href="assets/css/register_style.css">
</head>
<body>

<div class="wrapper">
  <div class="login_box">
  <div class="login_header">
    <h2>Stang Club Maryland</h2>
  </div>

  <form action="register.php" method="POST">
    <?php
if (in_array("<span class='text-danger'>Please enter the correct email and password!</span>", $error_array)) {
    echo "<span class='text-danger'>Please enter the correct email and password!</span><br>";
}
?>
    <input type="email" name="log_email" placeholder="Enter Email" value="
    <?php
if (isset($_SESSION['log_email'])) {
    echo $_SESSION['log_email'];
}
?>
    " required
    ><br>
    <input type="password" name="log_password" placeholder="Enter Password"><br>
    <input type="submit" name="login_button" value="Login"><br>
  </form>

  <form class="text-center" action="register.php" method="POST">
    <input type="text" name="reg_fname" placeholder="First Name"
      value="
      <?php if (isset($_SESSION['reg_fname'])) {
    echo $_SESSION['reg_fname'];
}?>"
    required><br>
    <?php if (in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) {
    echo "<small class='text-danger'>Your first name must be between 2 and 25 characters</small><br>";
}
?>

    <input type="text" name="reg_lname" placeholder="Last Name"
      value="<?php if (isset($_SESSION['reg_lname'])) {
    echo $_SESSION['reg_lname'];
}?>"
    required><br>
    <?php if (in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) {
    echo "<small class='text-danger'>Your last name must be between 2 and 25 characters</small><br>";
}
?>

    <input type="email" name="reg_email" placeholder="Email"
    value="<?php if (isset($_SESSION['reg_email'])) {
    echo $_SESSION['reg_email'];
}?>"
  required><br>

    <input type="email" name="reg_email2" placeholder="Confirm Email"
    value="<?php if (isset($_SESSION['reg_email2'])) {
    echo $_SESSION['reg_email2'];
}?>"required><br>
  <?php if (in_array("Email already in use<br>", $error_array)) {
    echo "<small class='text-danger'>Email already in use</small><br>";
} else if (in_array("Invalid format <br>", $error_array)) {
    echo "<small class='text-danger'>Invalid format</small><br>";
} else if (in_array("Emails don't match<br>", $error_array)) {
    echo "<small class='text-danger'>Emails don't match</small><br>";
}
?>

    <input type="password" name="reg_password" placeholder="Password" required><br>
    <input type="password" name="reg_password2" placeholder="Confirm Password" required><br>
    <?php if (in_array("Your passwords do not match!<br>", $error_array)) {
    echo "<small class='text-danger'>Your passwords do not match!</small><br>";
} else if (in_array("Your password can only contain english characters or numbers<br>", $error_array)) {
    echo "<small class='text-danger'>Your password can only contain english characters or numbers</small><br>";
} else if (in_array("Your password must be between 5 and 30 characters<br>", $error_array)) {
    echo "<small class='text-danger'>Your password must be between 5 and 30 characters</small><br>";
}
?>
    <input type="submit" name="register_button" value="Register"><br>
    <?php
if (in_array("<span class='text-success'>You're all set! Go ahead and login</span><br>", $error_array)) {
    echo "<span class='text-success'>You're all set! Go ahead and login</span><br>";
}

?>
  </form>

</div>
</div>




<!-- BOOTSTRAP JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

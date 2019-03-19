<?php
require_once "db.php";

// Declaring variables to prevent errors
$fname = ""; // First name
$lname = ""; // Last name
$em = ""; // email
$em2 = ""; // email 2
$password = ""; // password
$password2 = ""; // password2
$date = ""; // sign up date
$error_array = []; // holds error messages

if (isset($_POST['register_button'])) {
    // first name
    $fname = mysqli_real_escape_string($conn, $fname); // remove html tags
    $fname = str_replace(' ', '', $fname); // remove spaces
    $fname = ucfirst(strtolower($fname)); // uppercase first letter

    // last name
    $lname = mysqli_real_escape_string($conn, $lname); // remove html tags
    $lname = str_replace(' ', '', $lname); // remove spaces
    $lname = ucfirst(strtolower($lname)); // uppercase first letter

    // email
    $em = mysqli_real_escape_string($conn, $em); // remove html tags
    $em = str_replace(' ', '', $em); // remove spaces
    $em = ucfirst(strtolower($em)); // uppercase first letter

    // email2
    $em2 = mysqli_real_escape_string($conn, $em2); // remove html tags
    $em2 = str_replace(' ', '', $em2); // remove spaces
    $em2 = ucfirst(strtolower($em2)); // uppercase first letter

    // password
    $password = mysqli_real_escape_string($conn, $password); // remove html tags

    // password2
    $password2 = mysqli_real_escape_string($conn, $password2); // remove html tags

    // date --- get current date
    $date = date("Y-m-d");

    // check if email match
    if ($em == $em2) {
        // Check if email is in valid format
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            // check if email already exists
            
        } else {
            echo "Invalid format";
        }
    } else {
        echo "Emails don't match";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome to Stang Club MD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- BOOTSTRAP  -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<form action="register.php" method="POST">
  <input type="text" name="reg_fname" placeholder="First Name" required><br>
  <input type="text" name="reg_lname" placeholder="Last Name" required><br>
  <input type="email" name="reg_email" placeholder="Email" required><br>
  <input type="email" name="reg_email2" placeholder="Confirm Email" required><br>
  <input type="password" name="reg_password" placeholder="Password" required><br>
  <input type="password" name="reg_password2" placeholder="Confirm Password" required><br>
  <input type="submit" name="register_button" value="Register">
</form>



</form>



<!-- BOOTSTRAP JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

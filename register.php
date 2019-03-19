<?php
session_start();
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
    $fname = mysqli_real_escape_string($conn, $_POST['reg_fname']); // remove html tags
    $fname = str_replace(' ', '', $fname); // remove spaces
    $fname = ucfirst(strtolower($fname)); // uppercase first letter
    $_SESSION['reg_fname'] = $fname; // stores first name into session variable

    // last name
    $lname = mysqli_real_escape_string($conn, $_POST['reg_lname']); // remove html tags
    $lname = str_replace(' ', '', $lname); // remove spaces
    $lname = ucfirst(strtolower($lname)); // uppercase first letter
    $_SESSION['reg_lname'] = $lname; // stores last name into session variable

    // email
    $em = mysqli_real_escape_string($conn, $_POST['reg_email']); // remove html tags
    $em = str_replace(' ', '', $em); // remove spaces
    $em = ucfirst(strtolower($em)); // uppercase first letter
    $_SESSION['reg_email'] = $em; // stores email into session variable

    // email2
    $em2 = mysqli_real_escape_string($conn, $_POST['reg_email2']); // remove html tags
    $em2 = str_replace(' ', '', $em2); // remove spaces
    $em2 = ucfirst(strtolower($em2)); // uppercase first letter
    $_SESSION['reg_email2'] = $em2; // stores email2 into session variable

    // password
    $password = mysqli_real_escape_string($conn, $_POST['reg_password']); // remove html tags

    // password2
    $password2 = mysqli_real_escape_string($conn, $_POST['reg_password2']); // remove html tags

    // date --- get current date
    $date = date("Y-m-d");

    // check if email match
    if ($em == $em2) {
        // Check if email is in valid format
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            // check if email already exists
            $e_check = mysqli_query($conn, "SELECT email FROM users WHERE email = '$em'");

            // count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if ($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }
        } else {
            array_push($error_array, "Invalid format <br>");
        }
    } else {
        array_push($error_array, "Emails don't match<br>");
    }

    if (strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }
    if (strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }
    if ($password != $password2) {
        array_push($error_array, "Your passwords do not match!<br>");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }
    if (strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
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

<form class="text-center" action="register.php" method="POST">
  <input type="text" name="reg_fname" placeholder="First Name"
    value="<?php if (isset($_SESSION['reg_fname'])) {
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
  <input type="submit" name="register_button" value="Register">
</form>



</form>



<!-- BOOTSTRAP JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

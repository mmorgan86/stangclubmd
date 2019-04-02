<?php
// Declaring variables to prevent errors
$fname = ""; // First name
$lname = ""; // Last name
$em = ""; // email
$em2 = ""; // email 2
$username = "";
$password = ""; // password
$password2 = ""; // password2
$date = ""; // sign up date
$error_array = []; // holds error messages

if (isset($_POST['register_button'])) {

    // @todo add a vehicle filter to not list vehicle if mustang not included somewhere in vehicle title
    // vehicle
    $vehicle = mysqli_real_escape_string($conn, $_POST['vehicle']);
    $vehicle = ucwords(str_replace(' ', '', $vehicle));
    $_SESSION['vehicle'] = $vehicle;

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

    // username 
    $username = mysqli_real_escape_string($conn, $_POST['reg_username']);
    $username = str_replace(' ', '', $username);
    $username = strtolower($username);

        // check if username is taken
        $user_query = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
        if(mysqli_num_rows($user_query) > 0) {
            array_push($error_array, "Username is already in use");
        }
        // enter username in db

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

    if (empty($error_array)) {
        $password = password_hash($password, PASSWORD_DEFAULT); // encrypt password before sending to database

        // @todo change this so user can create their own username
        // Generate username by concatenating first name and last name
        // $username = strtolower($fname . "_" . $lname);
        // $query = "SELECT username FROM users WHERE username = '$username'";
        // $check_username_query = mysqli_query($conn, $query);
        // $i = 0;
        // // if username exists add number to username
        // while (mysqli_num_rows($check_username_query > 0)) {
        //     $i++; // add 1 to i
        //     $username = $username . "_" . $i;
        //     $check_username_query = mysqli_query($conn, $query);
        // }

        // Default profile pic
        $rand = rand(1, 2); // random number between 1 and 2
        if ($rand == 1) {
            $profile_pic = "assets/images/profile_pics/defaults/noob1.jpg";
        } else {
            $profile_pic = "assets/images/profile_pics/defaults/noob2.png";
        }

        // enter new user into db
        $stmt = "INSERT INTO users VALUES (null, $vehicle, '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')";
        $query = mysqli_query($conn, $stmt);

        array_push($error_array, "<span class='text-success'>You're all set! Go ahead and login</span><br>");

        // clear session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";

    }

}

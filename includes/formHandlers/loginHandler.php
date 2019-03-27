<?php

if (isset($_POST['login_button'])) {

    // sanitize email
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $email);
    $_SESSION['log_email'] = $email; // store email into session variable

    $password = $_POST['log_password']; // GET PASSWORD
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $check_database_query = mysqli_query($conn, $query);
    $check_login_query = mysqli_num_rows($check_database_query);
    if ($check_login_query == 1) {
        $row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];
        $_SESSION['username'] = $username;
        $passwordFromDB = $row['password'];
        if (password_verify($password, $passwordFromDB)) {
            $password = $row['password'];

            // reopen account if customer logs in
            $user_closed_query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND user_closed = 'yes'");
            if (mysqli_num_rows($user_closed_query) == 1) {
                $reopen_account = mysqli_query($conn, "UPDATE users SET user_closed = 'no' WHERE email = '$email'");
            }

            header("Location: index.php");
            exit;
        } else {
            // check for errors
            array_push($error_array, "<span class='text-danger'>Please enter the correct email and password!</span>");
            // echo var_dump($errors_array);
            // header("Location: register.php");
            // exit;
        }

    }
}

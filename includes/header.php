<?php
require_once "config/config.php";

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$userLoggedIn'");

    $user = mysqli_fetch_array($user_details_query);
} else {
    // header("Location: register.php");
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>StangClubMD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery -->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  <!-- bootstrap.js -->
  <script src="assets/js/bootstrap.min.js"></script>

  <!-- bootstrap.css -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
  <div class="top_bar">
    <div class="logo">
      <!-- @todo add image here if I find one -->
      <a href="#">StangClubMD</a>
    </div>

    <nav>
      <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['username']; ?></a>
      <a href="index.php"><i class="fas fa-home fa-lg"></i></a>
      <a href="#"><i class="fas fa-envelope fa-lg"></i></a>
      <a href="#"><i class="fas fa-bell-o fa-lg"></i></a>
      <a href="#"><i class="fas fa-users fa-lg"></i></a>
      <a href="#"><i class="fas fa-cog fa-lg"></i></a>
    </nav>
  </div>

  <div class="row">
      <div class="col-lg-12">
        <div class="wrapper">
    
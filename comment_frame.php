<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
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

<?php
require_once "config/config.php";

include "includes/header.php";
include "includes/classes/User.php";
include "includes/classes/Post.php";

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$userLoggedIn'");

    $user = mysqli_fetch_array($user_details_query);
} else {
    // header("Location: register.php");
}

?>

<script>
  // toggle button to show and hide comments section for each post
  function toggle() {
    var el = document.getElementById('comment_section');

    if(el.style.display == 'block') {
      el.style.display == 'none';
    }else {
      el.style.display == 'block';
    }
  }
</script>

<?php

// get id of post
if(isset($_GET['post_id'])) {
  $post_id = $_GET['post_id'];
}

// query to get data
$user_query = mysqli_query($conn, "SELECT added_by, user_to FROM posts WHERE id = '$post_id'");

// store data in $row array
$row = mysqli_fetch_array($user_query);

// set data to variables
$posted_to = $row['added_by'];

// insert comment in database
if(isset($_POST['postComment' . $post_id])) {
 $post_body = $_POST['post_body'];
 $post_body = mysqli_real_escape_string($conn, $post_body);
 $date_time_now = date("Y-m-d H:i:s");
 
 $insert_post = mysqli_query($conn, "INSERT INTO comments VALUES('', '$post_body', '$userLoggedIn', '$post_to', '$date_time_now', 'no', '$post_id'");

  echo '<p>Comment Posted! </p>';
}




?>

<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" method="GET" id="comment_form"  name="post_comment<?php echo $post_id; ?>">

  <textarea name="post_body"></textarea>
  <input type="submit" class="btn btn-primary" name="postComment<?php echo $post_id; ?>" value="Post">
</form>

<!-- Load comments -->

</body>
</html>
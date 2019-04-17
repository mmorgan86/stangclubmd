<?php
require_once "config/config.php";

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$userLoggedIn'");

    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
    </script> 

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
  <style>
    body {
      background-color: #fff;
    }
  </style>

  <?php

  $post_id = '';

  // get id of post
  if(isset($_REQUEST['post_id'])) {
    $post_id = $_REQUEST['post_id'];
  }
  
  $get_likes = mysqli_query($conn, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
  $row = mysqli_fetch_array($get_likes);
  $total_likes = $row['likes'];
  $user_liked = $row['added_by'];

  $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user_liked'");
  $row = mysqli_fetch_array($user_details_query);
  $total_user_likes = $row['num_likes'];

  // like button

  // update value of likes in like table
  if(isset($_POST['like_button'])) {
    $total_likes++;
    $query = mysqli_query($conn, "UPDATE posts SET likes = '$total_likes' WHERE id = '$post_id'");
    // adds a like to that users table
    $total_user_likes++;

    //update num of user likes
    $user_likes = mysqli_query($conn, "UPDATE users SET num_likes = '$total_user_likes' WHERE username = '$user_liked'");

    // insert user into likes db
    $insert_user = mysqli_query($conn, "INSERT INTO likes VALUES ('', '$userLoggedIn', '$post_id')");

    // insert notification

    // refresh page
    echo '<script>
    parent.window.location.reload();
    </script>';

  }

  // unlike button
  if(isset($_POST['unlike_button'])) {
    $total_likes--;
    $query = mysqli_query($conn, "UPDATE posts SET likes = '$total_likes' WHERE id = '$post_id'");
    // adds a like to that users table
    $total_user_likes--;

    //update num of user likes
    $user_likes = mysqli_query($conn, "UPDATE users SET num_likes = '$total_user_likes' WHERE username = '$user_liked'");

    // remove like from database
    $remove_like = mysqli_query($conn, "DELETE FROM likes WHERE username = '$userLoggedIn' AND post_id='$post_id'");


    // refresh page
    echo '<script>
    parent.window.location.reload();
    </script>';
  }

  // check for previous likes
  $check_query = mysqli_query($conn, "SELECT * FROM likes WHERE username ='$userLoggedIn' AND post_id = $post_id");
  $num_rows = mysqli_num_rows($check_query);

  if($num_rows > 0) {
    // unlike button
    echo '<form action="like.php?post_id=' .$post_id .'" method="POST">
      <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
      <div class="like_value">
        '.$total_likes.' <i class="fas fa-heart"></i>
      </div>
    </form>
    ';
  } else {
    // like button
    echo '<form action="like.php?post_id=' .$post_id .'" method="POST">
      <input type="submit" class="comment_like" name="like_button" value="Like">
      <div class="like_value">
        '.$total_likes.' <i class="fas fa-heart"></i>
      </div>
    </form>
    ';
  }
  ?>
  
</body>
</html>
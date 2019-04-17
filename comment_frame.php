<?php
require_once "config/config.php";
include "includes/classes/User.php";

if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$userLoggedIn'");

    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}

?>

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
<script>
  // toggle button to show and hide comments section for each post
  function toggle() {
    var el = document.getElementById('comment_section');

    if(el.style.display == 'block') {
      el.style.display = 'none';
    }else {
      el.style.display = 'block';
    }
  }
</script>

<?php

$post_id = '';

// get id of post
if(isset($_REQUEST['post_id'])) {
  $post_id = $_REQUEST['post_id'];
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
 
 $insert_post = mysqli_query($conn, "INSERT INTO comments VALUES('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");

  echo '<p>Comment Posted! </p>';
}




?>

<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" method="POST" id="comment_form"  name="post_comment<?php echo $post_id; ?>">

  <textarea name="post_body"></textarea>
  <input type="submit" class="btn btn-primary" name="postComment<?php echo $post_id; ?>" value="Post">
</form>

<!-- Load comments -->

<?php 
$get_comments = mysqli_query($conn, "SELECT * FROM comments WHERE post_id = '$post_id' ORDER BY id ASC");

$count = mysqli_num_rows($get_comments);

if($count != 0) {
  while ($comment = mysqli_fetch_array($get_comments)) {
    $comment_body = $comment['post_body'];
    $posted_to = $comment['posted_to'];
    $posted_by = $comment['posted_by'];
    $date_added = $comment['date_added'];
    $removed = $comment['removed'];

    // Get timeframe
    $date_time_now = date("Y-m-d H:i:s");
    // time of post
    $start_date = new DateTime($date_added);
    // current time
    $end_date = new DateTime($date_time_now); 

    // difference between dates
    $interval = $start_date->diff($end_date);

    if($interval->y >= 1) {
      if($interval->y == 1) {
        // 1 year ago
        $time_message = $interval->y ." year ago"; // 1 year ago
      } else {
        $time_message = $interval->y. " years ago"; // 1+ year ago
      }
    } else if($interval->m >= 1) {
        if($interval->d == 0) {
        $days = " ago";
        }
        else if ($interval->d == 1){
          $days = $interval->d . " day ago";
        }
        else {
          $days = $interval->d . " days ago";
        }
        if($interval->m == 1) {
          $time_message = $interval->m. " month" .$days;
        }
        else {
          $time_message = $interval->m. " months" .$days;
        }
    } else if($interval->d >= 1) {
        if($interval->d == 1) {
          $time_message = ' Yesterday';
        } else {
          $time_message = $interval->d ." days ago";
        }
    } else if($interval->h >= 1) {
        if($interval->h == 1) {
          $time_message = $interval->h .' hour ago';
        } else {
          $time_message = $interval->h ." hours ago";
        }
      
    }else if($interval->i >= 1) {
        if($interval->i == 1) {
          $time_message = $interval->i .' minute ago';
        } else {
          $time_message = $interval->i." mins ago";
        }

    }
    else {
      if($interval->s < 30) {
        $time_message = ' Just now';
      } else {
        $time_message = $interval->s ." seconds ago";
      }
    }

    $user_obj = new User($conn, $posted_by);

    ?>
    <div class="comment_section">
      <a href="<?php echo $posted_by; ?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic(); ?>" title="<?php echo $posted_by; ?>" style="float:left" height="30"; /></a>

      <a href="<?php echo $posted_by; ?>" target="_parent"> <b><?php echo $user_obj->getUsername(); ?> </b></a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <span style="color: #acacac;"><?php echo $time_message . '</span><br><div>' .$comment_body .'</div>' ?>
      <hr>
      
    </div>

    <?php
  }
}
else {
  echo "<center><br><br> No comments to show! </center>";
}

?>

</body>
</html>
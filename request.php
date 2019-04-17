<?php
include "includes/header.php";

?>
<div class="main_column column" id="main_column">
  <h4>Friend Requests</h4>

  <?php

  $query = mysqli_query($conn, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");

  if(mysqli_num_rows($query) == 0 ) {
    echo 'You have no friend request at this time';
  } else {
    while($row =  mysqli_fetch_array($query)) {
      $user_from = $row['user_from'];
      $user_from_obj = new user($conn, $user_from);

      echo $user_from_obj->getUsername() ." sent you a friend request!";

      // get user from friends array
      $user_from_friend_array = $user_from_obj->getFriendArray();

      if(isset($_POST['accept_request' . $user_from])) {
        // add friends
        $add_friend_query = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') where username='$userLoggedIn'");
        $add_friend_query = mysqli_query($conn, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') where username='$user_from'");

        // delete request
        $delete_query = mysqli_query($conn, "DELETE FROM friend_request WHERE user_to='$userLoggedIn' AND user_from='$user_from'");

        echo "You are now friends";
        header("Location: request.php");

      }
      if(isset($_POST['ignore_request' . $user_from])) {
        // delete request
        $delete_query = mysqli_query($conn, "DELETE FROM friend_request WHERE user_to='$userLoggedIn' AND user_from='$user_from'");

        echo "Request Ignored";
        header("Location: request.php");
      }

      ?>
      <form action="requests.php" method="POST">
        <input type="submit" class="btn btn-success" name="accept_request<?php $user_from; ?>" id="accept_button" value="Accept"/>

        <input type="submit" class="btn btn-danger" name="ignore_request<?php $user_from; ?>" id="ignore_button" value="Ignore"/>
      </form>

      <?php
    }
  }

  ?>
  

</div>
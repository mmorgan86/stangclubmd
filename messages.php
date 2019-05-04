<?php

include('includes/header.php');

$message_obj = new Message($conn, $userLoggedIn);

if (isset($_GET['u'])) {
  $user_to = $_GET['u'];
} else {
  $user_to = $message_obj->getMostRecentUser();

  if($user_to == false ) {
    $user_to = 'new';
  }
}

if($user_to != 'new') {
  $user_to_obj = new User($conn, $user_to);
}

if(isset($_POST['post_message'])) {
  if(isset($_POST['message_body'])) {
    $body = mysqli_real_escape_string($conn, $_POST['message_body']);
    $date = date('Y-m-d H:i:s');
    $message_obj->sendMessage($user_to, $body, $date);
  }
}
?>
<!-- user details (right column) -->
<div class="user_details column">
  <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ?>" /></a>
  <div class="user_details_left_right">
    <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['username']; ?>
    </a>
    <a href="#" id="vehicle"><?php echo $user['vehicle']; ?></a>
    <br>
    <?php echo "Posts: " . $user['num_posts'] . "<br>";
          echo "likes: " . $user['num_likes'];
    ?>    
  </div>
</div>

<div class="main_column column" id="main_column">
  <?php
    if($user_to != 'new') {
      echo '<h4>You and <a href="user_to">' .$user_to_obj->getUsername() .'</a></h4><hr><br>',
            '<div class="load_messages">',
            $message_obj->getMessages($user_to),
            '</div>';
    } else {
      echo '<h4>New Messages</h4>';
    }
  ?>
  <div class="message_post">
    <form action="" method="POST">
      <?php 
        if($user_to == 'new') {
          echo 'Select the friend you would like to message <br><br>',
              "To: <input type='text' >",
              "<div class='results'></div>";
        } else {
          echo "<textarea name='message_body' id='message_textarea' placeholder='Write your message...'></textarea>",
          "<input type='submit' name='post_message' id='message_submit' value='send'>";
        }
      ?>
    </form>
  </div>
</div>


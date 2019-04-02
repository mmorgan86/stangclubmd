<?php
include "includes/header.php";
include "includes/classes/User.php";
include "includes/classes/Posts.php";

if(isset($_POST['post'])) {
  $post = new Post($conn, $userLoggedIn);
  $post->submitPost($_POST['post_text'], 'none');
}

?>

<!-- @todo change image and name when clicked on goes to username -->

<div class="user_details column">
  <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ?>" /></a>
  <div class="user_details_left_right">
    <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?>
    </a>
    <a href="#" id="vehicle"><?php echo $user['vehicle']; ?></a>
    <br>
    <?php echo "Posts: " . $user['num_posts'] . "<br>";
            echo "likes: " . $user['num_likes'];
    ?>    
  </div>
</div>

<div class="main_column column">
  <form action="index.php" method="POST" class="post_form">
    <textarea name="post_text" id="post_text" cols="30" rows="10" placeholder="Got something to say?"></textarea>
    <input type="submit" name="post" id="post_button" value="Post">
    <hr>
  </form>

  <?php
$user_obj = new User($conn, $userLoggedIn);
echo $user_obj->getUsername();
?>
</div>


</div> <!-- End of wrapper (in header.php) -->
</div> <!-- End col-lg-12 -->
</div> <!-- End row -->

</body>
</html>

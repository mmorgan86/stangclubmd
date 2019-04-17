<?php
include "includes/header.php";

// when button post button is click send message data
if(isset($_POST['post'])) {
  $post = new Post($conn, $userLoggedIn);
  $post->submitPost($_POST['post_text'], 'none');
}

?>

<!-- @todo change image and name when clicked on goes to username -->

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


<!-- post message form -->
<div class="main_column column">
  <form action="index.php" method="POST" class="post_form">
    <textarea name="post_text" id="post_text" cols="30" rows="10" placeholder="Got something to say?"></textarea>
    <input type="submit" name="post" id="post_button" value="Post">
    <hr>
  </form>
  <div class="post_area"></div>
</div>

<img id="loading" src="assets/images/icons/mustang_loader.gif">

<script>
  //  dynamically load post on page scroll
   $(function(){
      
       var userLoggedIn = '<?php echo $userLoggedIn; ?>';
       var inProgress = false;
 
       loadPosts(); //Load first posts
 
       $(window).scroll(function() {
           var bottomElement = $(".status_post").last();
           var noMorePosts = $('.post_area').find('.noMorePosts').val();
 
           // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
           if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
               loadPosts();
           }
       });
 
       function loadPosts() {
           if(inProgress) { //If it is already in the process of loading some posts, just return
               return;
           }
          
           inProgress = true;
           $('#loading').show();
 
           var page = $('.post_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
 
           $.ajax({
               url: "includes/handlers/ajax_load_posts.php",
               type: "POST",
               data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
               cache:false,
 
               success: function(response) {
                   $('.post_area').find('.nextPage').remove(); //Removes current .nextpage
                   $('.post_area').find('.noMorePosts').remove(); //Removes current .nextpage
                   $('.post_area').find('.noMorePostsText').remove(); //Removes current .nextpage
 
                   $('#loading').hide();
                   $(".post_area").append(response);
 
                   inProgress = false;
               }
           });
       }
 
       //Check if the element is in view
       function isElementInView (el) {
             if(el == null) {
                return;
            }
 
           var rect = el.getBoundingClientRect();
 
           return (
               rect.top >= 0 &&
               rect.left >= 0 &&
               rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
               rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
           );
       }
   });
 
   </script>

</div> <!-- End of wrapper (in header.php) -->
</div> <!-- End col-lg-12 -->
</div> <!-- End row -->

</body>
</html>

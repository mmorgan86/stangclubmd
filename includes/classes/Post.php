<?php

class Post {
  private $user_obj;
  private $conn;

  public function __construct($conn, $user) {
      $this->conn = $conn;
      $this->user_obj = new User($conn, $user);
  }

  public function submitPost($body, $user_to) {
    $body = strip_tags($body); // removes html tags
    $body = mysqli_real_escape_string($this->conn, $body);

    // Delete all spaces
    $check_empty = preg_replace('/\s+/', '', $body); 
    if($check_empty != '') {

      // current date and time
      $date_added = date("Y-m-d H:i:s");

      // Get user name
      $added_by = $this->user_obj->getUsername();

      // If user is on own profile, user_to is 'none'
      if($user_to == $added_by) {
        $user_to = 'none';
      }

      // Insert post
      $query = mysqli_query($this->conn, "INSERT INTO posts VALUES ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0') ");
      $returned_id = mysqli_insert_id($this->conn);

      // Insert notification

      //Update post count for user
      $num_posts = $this->user_obj->getNumPosts();
      $num_posts ++;
      $update_query = mysqli_query($this->conn, "UPDATE users SET num_posts = '$num_posts' WHERE username = '$added_by' ");
      echo 'added by= ' .$added_by .' '.'num post= ' .$num_posts;
    }
    header("Location: index.php");
  }

  public function loadPostsFriends($data, $limit) {

    $page = $data['page'];
    $userLoggedIn = $this->user_obj->getUsername();

    if($page == 1) {
      $start = 0;
    } else {
      $start = ($page - 1) * $limit;
    }

    $str = ''; // string to return
    $data_query = mysqli_query($this->conn, "SELECT * FROM posts WHERE deleted ='no' ORDER BY id DESC");

    if(mysqli_num_rows($data_query) > 0) {
       
      // count number of results 
      $num_iterations = 0; 
      $count = 1;


      while($row = mysqli_fetch_array($data_query)) {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];

        // prepare user_to string so it can be included even if not posted to a user
        if($row['user_to'] == 'none') {
          $user_to = '';
        } else {
          $user_to_obj = new User($this->conn, $row['user_to']);
          $user_to_username = $user_to_obj->getUsername();
          $user_to = " to <a href='" .row['user_to'] ."'>" .$user_to_username ."</a>";
        }

        // Check if user who posted, has their account closed
        $added_by_obj = new User($this->conn, $added_by); 
        if($added_by_obj->isClosed()) {
          continue;
        }

        // get user friends from friend array
        $user_logged_obj = new User($this->conn, $userLoggedIn);
        if($user_logged_obj->isFriend($added_by)) {
          
          // get to number of post that have been loaded
          if($num_iterations++ < $start)
            continue;

          // once 10 posts have been loaded break
          if($count > $limit) {
            break;
          } else {
            $count++;
          }
          $user_details_query = mysqli_query($this->conn, "SELECT first_name, last_name, profile_pic, username FROM users WHERE username = '$added_by'");
          $user_row = mysqli_fetch_array($user_details_query);

          // Get profile pic
          $first_name = $user_row['first_name'];
          $last_name = $user_row['last_name'];
          $profile_pic = $user_row['profile_pic'];
          $username = $user_row['username'];
          
          ?>
          <!-- Dispaly comments -->
          <script>
            // toggle button to show and hide comments section for each post
            function toggle<?php echo $id; ?>() {
              var el = document.getElementById('toggleComment<?php echo $id; ?>');

              if(el.style.display == 'block') {
                el.style.display == 'none';
              }else {
                el.style.display == 'block';
              }
            }
          </script>

          <?php
          // Get timeframe
          $date_time_now = date("Y-m-d H:i:s");
          // time of post
          $start_date = new DateTime($date_time);
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
          $str .= "<div class='status_post' onClick='javascript:toggle$id()'>
                    <div class='post_profile_pic'>
                      <img src='$profile_pic' width='50'>
                    </div>
                    <div class='post_by' style='color:#ACACAC;'>
                      <a href='$added_by'>$username </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$time_message
                    </div>
                    <div id='post_body'>
                      $body
                      <br>
                    </div>
                  </div>
                  <div class='post_comment' id='toggleComment$id' style='display:none'>
                    <iframe src='comment_frame.php?post_id=$id' id='comment_iframe'></iframe>
                  </div>
                  <hr>";
        }
      } // End while loop
      if($count > $limit) {
        $str .= "<input type='hidden' class='nextPage' value='".($page + 1)."'>
                  <input type='hidden' class='noMorePosts' value='false'>";
      } else {
        $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> No more posts to show </p>";
      }
    }
    echo $str;
  }
}
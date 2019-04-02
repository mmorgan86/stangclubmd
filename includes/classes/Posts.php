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
      $num_posts = $this->user_obj->getNumposts();
      $num_posts++;
      $update_query = mysqli_query($this->conn, "UPDATE users GET num_posts = '$num_posts' WHERE username = '$added_by' ");

    }
  }



}
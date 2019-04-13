<?php

class User {
  private $user;
  private $conn;

  public function __construct($conn, $user) {
      $this->conn = $conn;

      $user = mysqli_real_escape_string($conn, $user);
      $query = "SELECT * FROM users WHERE username = '$user'";
      $user_details_query = mysqli_query($conn, $query);
      $this->user = mysqli_fetch_array($user_details_query);
  }

  public function getUsername() {
    return $this->user['username'];
  }

  public function getNumPosts() {
    $username = $this->user['username'];
    $query = mysqli_query($this->conn, "SELECT num_posts FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['num_posts'];
  }

  // get first and last name
  public function getFirstAndLastName() {
    $username = $this->user['username'];
    $query = mysqli_query($this->conn, "SELECT first_name, last_name FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['first_name'] . ' ' .$row['last_name'];
  }

  // get profile pic
  public function getProfilePic() {
    $username = $this->user['username'];
    $query = mysqli_query($this->conn, "SELECT profile_pic FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['profile_pic'];
  }

  // check is user account is closed
  public function isClosed() {
    $username = $this->user['username'];
    $query = mysqli_query($this->conn, "SELECT user_closed FROM users WHERE username = '$username'");
    $row = mysqli_fetch_array($query);
    if($row['user_closed'] == 'yes') {
      return true;
    } else {
      return false;
    }
  }

  public function isFriend($username_to_check) {
    $usernameComma = "," . $username_to_check . ",";

    if(strstr($this->user['friend_array'], $usernameComma) || $username_to_check == $this->user['username']) {
      return true;
    } else {
      return false;
    }
  }



}
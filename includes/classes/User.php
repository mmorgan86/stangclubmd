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

  // get friend array
  public function getFriendArray() {
    $username = $this->user['username'];
    $query = mysqli_query($this->conn, "SELECT friend_array FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['friend_array'];
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

  // checks if a request was sent into the friend_request table. if so it return true if not it returns false.
  public function didReceiveRequest($user_from) {
    $user_to = '';
    $user_to = $this->user['username'];
    $check_request_query = mysqli_query($this->conn, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND  user_from='$user_from'");

    if(mysqli_num_rows($check_request_query) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function didSendRequest($user_to) {
    $user_from = '';
    $user_from = $this->user['username'];
    $check_request_query = mysqli_query($this->conn, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND  user_from='$user_from'");

    if(mysqli_num_rows($check_request_query) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function removeFriend($user_to_remove) {
    $logged_in_user = $this->user['username'];
    
    // get friend array
    $query = mysqli_query($this->conn, "SELECT friend_array FROM users WHERE username='$user_to_remove'");  
    $row = mysqli_fetch_array($query);
    $friend_array_username =  $row['friend_array'];

    $new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']);
    // remove friend from remover
    $remove_friend = mysqli_query($this->conn, "UPDATE users SET friend_array = '$new_friend_array' WHERE username ='$logged_in_user'");

    // find and remove their name from the friend
    $new_friend_array = str_replace($this->user['friend_array']. ",", "", $friend_array_username);
    // remove friend from remover
    $remove_friend = mysqli_query($this->conn, "UPDATE users SET friend_array = '$new_friend_array' WHERE username ='$user_to_remove'");
  }

  public function sendRequest($user_to) {
    $user_from = $this->user['username'];
    $query = mysqli_query($this->conn, "INSERT INTO friend_requests VALUES ('', '$user_to', '$user_from')");
  }


}
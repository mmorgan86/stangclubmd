<?php

class Message {
  private $user_obj;
  private $conn;

  public function __construct($conn, $user) {
      $this->conn = $conn;
      $this->user_obj = new User($conn, $user);
  }

  public function getMostRecentUser() {
    $userLoggedIn = $this->user_obj->getUsername();

    $query = mysqli_query($this->conn, "SELECT user_to, user_from FROM messages WHERE user_to = '$userLoggedIn' OR user_from = '$userLoggedIn' ORDER BY id DESC limit 1");

    if(mysqli_num_rows($query) == 0) {
      return false;
    }

    $row = mysqli_fetch_array($query);
    $user_to = $row['user_to'];
    $user_from = $row['user_from'];

    if($user_to != $userLoggedIn) {
      return $user_to;
    } else {
      return $user_from;
    }

  }

  public function sendMessage($user_to, $body, $date) {
    if($body != '') {
      $userLoggedIn = $this->user_obj->getUsername();
      $query = mysqli_query($this->conn, "INSERT INTO messages VALUES('','$user_to', '$userLoggedIn', '$body', '$date', 'no', 'no', 'no')");

      if(!$query) {
        echo 'sendMessage query error: ' .mysqi_error($conn);
        die();
      }
    }
  }

  public function getMessages($otherUser) {
    // get username and set data to a empty string
    $userLoggedIn = $this->user_obj->getUsername();
    $data = '';

    // update the messages table and set this message to opened
    $query = mysqli_query($this->conn, "UPDATE messages SET opened='yes' WHERE user_to='$userLoggedIn' AND user_from='$otherUser'");
    if(!$query) {
      echo 'getMessage Query Failed: ' .mysqli_error($conn);
    }
    // restrieve the messages between this two users
    $get_messages_query = mysqli_query($this->conn, "SELECT * FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$otherUser') OR (user_from='$userLoggedIn' AND user_to='$otherUser') ");
  }

}
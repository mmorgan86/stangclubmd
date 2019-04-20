<?php
// infinite scroll

include_once('../../config/config.php');
include_once("../classes/User.php");
include_once("../classes/Post.php");

// Number of post to be loaded per call
$limit = 10; 

$posts = new Post($conn, $_REQUEST['userLoggedIn']);
$posts->loadProfilePosts($_REQUEST, $limit);
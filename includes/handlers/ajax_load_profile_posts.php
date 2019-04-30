<?php
// infinite scroll

require_once "../../config/config.php";
include("../../includes/classes/User.php");
include("../../includes/classes/Post.php");
// Number of post to be loaded per call
$limit = 10; 

$posts = new Post($conn, $_REQUEST['userLoggedIn']);
$posts->loadProfilePosts($_REQUEST, $limit);
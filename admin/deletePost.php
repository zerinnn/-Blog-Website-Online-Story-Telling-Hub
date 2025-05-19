<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    //fetch user from database
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id =$id";
    $result = mysqli_query($dbConnection, $query);

    $post =  mysqli_fetch_assoc($result);


    if (mysqli_num_rows($result) == 1) {
        
        $avatarName = $post['thumbnail'];
        $avatarPath = '../images/' . $avatarName;

        unlink($avatarPath);
    }

    //delete user
    $deletePostQuery = "DELETE FROM posts WHERE id = $id";
    $deletePostResult = mysqli_query($dbConnection, $deletePostQuery);

    if (mysqli_errno($dbConnection)) {
        $_SESSION['deletePost'] = "Couldn't delete.";
    } else {
        $_SESSION['deletePostSuccess'] = "Post  deleted successfully.";
    }
}
header('Location: ' . ROOT_URL . 'admin/index.php');
die();

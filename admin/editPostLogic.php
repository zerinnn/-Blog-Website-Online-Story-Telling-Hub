<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previousThumbnailName = filter_var($_POST['previousThumbnailName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $badge = filter_var($_POST['badge'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $isFeatured = 0;

    if (isset($_POST['isFeatured'])) {
        $isFeatured = 1;
    }
    if (!$badge) {
        $badge = "";
    }

    // Validate data
    if (!$title || !$categoryId || !$body) {
        $_SESSION['editPost'] = "Couldn't update post. Invalid form data on edit post page.";
      
    }

    if ($thumbnail['name']) {
        $previousThumbnailPath = '../images/' . $previousThumbnailName;
        if (file_exists($previousThumbnailPath)) {
            unlink($previousThumbnailPath);
        }

        $time = time();
        $thumbnailName = $time . '_' . $thumbnail['name'];
        $thumbnailTempName = $thumbnail['tmp_name'];
        $thumbnailDestinationPath = '../images/' . $thumbnailName;

        $allowedFiles = ['png', 'jpg', 'jpeg'];
        $extension = pathinfo($thumbnailName, PATHINFO_EXTENSION);

        if (in_array($extension, $allowedFiles)) {
            if ($thumbnail['size'] < 3000000) {
                move_uploaded_file($thumbnailTempName, $thumbnailDestinationPath);
            } else {
                $_SESSION['editPost'] = "Couldn't update post. Thumbnail size too big. Should be less than 3MB.";
            }
        } else {
            $_SESSION['editPost'] = "Thumbnail extension must be png, jpg, or jpeg.";
        }
    }

    if($_SESSION['editPost']){
        header('Location: ' . ROOT_URL .'admin/editPost.php?id=' . $id);
        die();
    }else{
        try{

            $insertThumbnail = $thumbnailName ?? $previousThumbnailName;


            $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$insertThumbnail', categoryId=$categoryId, isFeatured=$isFeatured WHERE id=$id";

            $result = mysqli_query($dbConnection, $query);
        }catch(Exception $error){
            $_SESSION['editPost'] = $error;
        }
    }

    if(!mysqli_errno($dbConnection)){
        $_SESSION['editPostSuccess'] = 'Post updated successfully';
    }

    
   
}

header('Location:' . ROOT_URL .'admin/editPost.php?id=' . $id);
die();

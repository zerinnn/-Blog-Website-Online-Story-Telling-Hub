<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $userId = $_SESSION['userId'];

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $badge = filter_var($_POST['badge'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['article'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //if not checked on featured
    $isFeatured = 0;

    if (isset($_POST['isFeatured'])) {
        $isFeatured = 1;
    }
    if (!$badge) {
        $badge = "";
    }
    //validate data
    if (!$title) {
        $_SESSION['addPost'] = "Enter Post Title";
    } else if (!$categoryId) {
        $_SESSION['addPost'] = "Select Category";
    } else if (!$body) {
        $_SESSION['addPost'] = "Enter post article";
    } else if (!$thumbnail['name']) {
        $_SESSION['addPost'] = "Choose post thumbnail";
    } else {
        $time = time();
        $thumbnailName = $time . $thumbnail['name'];
        $thumbnailTempName = $thumbnail['tmp_name'];
        $thumbnailDestinationPath = '../images/' . $thumbnailName;

        $allowedFiles = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnailName);
        $extension = end($extension);

        if (in_array($extension, $allowedFiles)) {
            if ($thumbnail['size'] < 3000000) {
                move_uploaded_file($thumbnailTempName, $thumbnailDestinationPath);
            } else {
                $_SESSION['addPost'] = "File size is too large, should be less than 3mb";
            }
        } else {
            $_SESSION['addPost'] = "file extension must be png, jpg or jpeg";
        }
    }
    if ($_SESSION['addPost']) {
        header('Location:' . ROOT_URL . 'admin/addPost.php');
        die();
    } else {
        $insertPostQuery = "INSERT INTO posts (title, body, thumbnail, categoryId, userId, isFeatured, badge) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($dbConnection, $insertPostQuery);

        mysqli_stmt_bind_param($stmt, "sssiiis", $title, $body, $thumbnailName, $categoryId, $userId, $isFeatured, $badge);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['addPostSuccess'] = "Post added successfully.";
            header('Location:' . ROOT_URL . 'admin/addPost.php');
            die(); 
        } else {
            $_SESSION['addPost'] = "Failed to post. Please try again later.";
            header('Location:' . ROOT_URL . 'admin/addPost.php');
            die(); 
        }

        mysqli_stmt_close($stmt);
        mysqli_close($dbConnection);
    }
} else {
    //if btn wan't clicked
    header('Location:' . ROOT_URL . 'admin/addPost.php');
    die();
}

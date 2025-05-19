<?php

require 'config/database.php';

if (isset($_POST['submit'])) {
    echo 'hi';

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $avatar = $_FILES['thumbnail'];

    if (!$title) {
        $_SESSION['addCategory'] = ' Enter Title';
    } else if (!$description) {
        $_SESSION['addCategory'] = ' Enter Description';
    } else if (!$avatar) {
        $_SESSION['addCategory'] = "Please add thumbnail";
    }
    //For image validation
    else {
        $time = time();
        $avatarName = $time . $avatar['name'];
        $avatarTempName = $avatar['tmp_name'];
        $avatarDestinationPath = '../images/' . $avatarName;

        $allowedFiles = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatarName);
        $extension = end($extension);

        if (in_array($extension, $allowedFiles)) {
            if ($avatar['size'] < 1000000) {
                move_uploaded_file($avatarTempName, $avatarDestinationPath);
            } else {
                $_SESSION['addCategory'] = "File size is too large, should be less than 1mb";
            }
        } else {
            $_SESSION['addCategory'] = "file extension must be png, jpg or jpeg";
        }
    }

    // redirect back to add category page with form data if there was invalid input

    if (isset($_SESSION['addCategory'])) {
        header('Location: ' . ROOT_URL . 'admin/addCategory.php');
        die();
    }else{
        $query = "INSERT INTO categories (title, description, avatar) VALUES ('$title', '$description', '$avatarName')";
        $result = mysqli_query($dbConnection, $query);

        if(mysqli_errno($dbConnection)){
            $_SESSION['addCategory'] = "Couldn't add category";
            header('Location: '. ROOT_URL . 'admin/addCategory.php');
            die();
        }else{
            $_SESSION['addCategorySuccess'] = "Category $title added successfully";
            header('Location: ' . ROOT_URL . 'admin/addCategory.php');
            die();
        }
    }
} else {
    header('Location: ' . ROOT_URL . 'admin/addCategory.php');
    die();
}

<?php

require 'config/database.php';
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //check valid input
    if (!$title || !$description) {
        $_SESSION['editCategory'] = "Invalid form input on edit category page.";
    } else {
        //update user
        $query = "UPDATE categories SET title = '$title' , description = '$description' WHERE id=$id LIMIT 1";
        $categoryResult = mysqli_query($dbConnection, $query);

        if (mysqli_errno($dbConnection)) {
            $_SESSION['editCategory'] = "Failed to update category";
        } else {
            $_SESSION['editCategorySuccess'] = "User $title Updated successfully";
        }
    }
}

header('Location: ' . ROOT_URL . 'admin/manageCategory.php');
die();

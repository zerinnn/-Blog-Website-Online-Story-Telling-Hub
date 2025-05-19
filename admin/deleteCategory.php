<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    //fetch category from database
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM categories WHERE id =$id";
    $categoryResult = mysqli_query($dbConnection, $query);

    $category =  mysqli_fetch_assoc($categoryResult);


    if (mysqli_num_rows($categoryResult) == 1) {
        
        $avatarName = $category['avatar'];
        $avatarPath = '../images/' . $avatarName;

        unlink($avatarPath);
    }

    //delete user
    $deleteUserQuery = "DELETE FROM categories WHERE id = $id";
    $deleteUserResult = mysqli_query($dbConnection, $deleteUserQuery);

    if (mysqli_errno($dbConnection)) {
        $_SESSION['deleteCategory'] = "Couldn't {$user['firstName']} {$user['lastName']} delete user.";
    } else {
        $_SESSION['deleteCategorySuccess'] = "Category {$category['title']} deleted successfully.";
    }
}
header('Location: '. ROOT_URL . 'admin/manageCategory.php');
die();

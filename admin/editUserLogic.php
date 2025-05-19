<?php

require 'config/database.php';
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $fname = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lname = filter_var($_POST['lname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userRole = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    //check valid input
    if (!$fname || !$lname) {
        $_SESSION['editUser'] = "Invalid form input on edit page.";
    } else {
        //update user
        $query = "UPDATE account SET firstName = '$fname' , lastName = '$lname', isAdmin = $userRole WHERE id=$id LIMIT 1";
        $result = mysqli_query($dbConnection, $query);

        if (mysqli_errno($dbConnection)) {
            $_SESSION['editUser'] = "Failed to update user";
        } else {
            $_SESSION['editUserSuccess'] = "User $fname $lname Updated successfully";
        }
    }
}

header('Location: ' . ROOT_URL . 'admin/manageUser.php');
die();

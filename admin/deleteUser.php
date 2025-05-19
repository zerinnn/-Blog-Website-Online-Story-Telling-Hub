<?php
require 'config/database.php';

if(isset($_GET['id'])){
    //fetch user from database
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM account WHERE id =$id";
    $result = mysqli_query($dbConnection, $query);

    $user =  mysqli_fetch_assoc($result);

    
    if(mysqli_num_rows($result) == 1){
        var_dump($user);
        $avatarName = $user['avatar'];
        $avatarPath = '../images/' . $avatarName;

        unlink($avatarPath);

    }

    //delete user
    $deleteUserQuery = "DELETE FROM account WHERE id = $id";
    $deleteUserResult = mysqli_query($dbConnection, $deleteUserQuery);

    if(mysqli_errno($dbConnection)){
        $_SESSION['deleteUser'] = "Couldn't {$user['firstName']} {$user['lastName']} delete user.";
    }else{
        $_SESSION['deleteUserSuccess'] = "User {$user['firstName']} {$user['lastName']} deleted successfully.";
    }
}
header('Location: '. ROOT_URL . 'admin/manageUser.php');
die();
?>
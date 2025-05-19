<?php
session_start();
require 'config/database.php';

if (isset($_POST['submit'])) {

    $firstName = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($_POST['lname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createPass = filter_var($_POST['createPass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmPass = filter_var($_POST['confirmPass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // echo $firstName, $lastName, $email, $username, $createPass, $confirmPass;
    //var_dump($avatar);

    if (!$firstName) {
        $_SESSION['signup'] = "Please enter first name";
    } else if (!$lastName) {
        $_SESSION['signup'] = "Please enter last name";
    } else if (!$username) {
        $_SESSION['signup'] = "Please enter username";
    } else if (!$email) {
        $_SESSION['signup'] = "Please enter a valid email";
    } else if (strlen($createPass) < 8 || strlen($confirmPass) < 8) {
        $_SESSION['signup'] = "Password should be at least 8 characters";
        if ($createPass !== $confirmPass) {
            $_SESSION['signup'] = "Password does not match";
        }
    } else if (!$avatar) {
        $_SESSION['signup'] = "Please add avatar";
    } else {
        $hashedPassword = password_hash($createPass, PASSWORD_DEFAULT);
        // echo $createPass . '<br>';
        // echo $hashedPassword;

        $userCheckQuery = "SELECT * FROM account WHERE username = '$username' OR email = '$email'";
        $userCheckResult = mysqli_query($dbConnection, $userCheckQuery);

        if (mysqli_num_rows($userCheckResult) > 0) {
            $_SESSION['signup'] = 'username or email already registered';
        } else {
            $time = time();
            $avatarName = $time . $avatar['name'];
            $avatarTempName = $avatar['tmp_name'];
            $avatarDestinationPath = 'images/' . $avatarName;

            $allowedFiles = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $avatarName);
            $extension = end($extension);

            if (in_array($extension, $allowedFiles)) {
                if ($avatar['size'] < 1000000) {
                    move_uploaded_file($avatarTempName, $avatarDestinationPath);
                } else {
                    $_SESSION['signup'] = "File size is too large, should be less than 1mb";
                }
            } else {
                $_SESSION['signup'] = "file extension must be png, jpg or jpeg";
            }
        }
    }

    if ($_SESSION['signup']) {
        header('Location:' . ROOT_URL . 'signup.php');
        die();
    } else {
        $insertUserQuery = "INSERT INTO account (firstName, lastName, username, email, password, avatar) VALUES ('$firstName','$lastName','$username','$email','$hashedPassword','$avatarName')";

        try {
            $insertUserResult = mysqli_query($dbConnection, $insertUserQuery);
            if (mysqli_errno($dbConnection)) {
                $_SESSION['signup'] = "Connection failed, Please try again later";
                header('Location:' . ROOT_URL . 'signup.php');
                die();
            } else {
                $_SESSION['signupSuccess'] = "Registration successful. Please login";
                header('Location:' . ROOT_URL . 'signin.php');
                die();
            }
        } catch (Exception $error) {
            $_SESSION['signup'] = "Registration failed, Please try again later.<br>".$error;
            header('Location:' . ROOT_URL . 'signup.php');
            die();
        }
        
    }
} else {
    //if btn wan't clicked
    header('Location:' . ROOT_URL . 'signup.php');
    die();
}

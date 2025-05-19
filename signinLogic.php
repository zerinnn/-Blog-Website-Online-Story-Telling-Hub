<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';

if (isset($_POST['submit'])) {
    $username = filter_var($_POST['usernameEmail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username) {
        $_SESSION['signin'] = "Username or email required";
    } else if (!$password) {
        $_SESSION['signin'] = "Password required";
    } else {
        $fetchUserQuery = "SELECT * FROM account WHERE username = '$username' OR email = '$username'";

        try {
            $fetchUserResult = mysqli_query($dbConnection, $fetchUserQuery);

            if (mysqli_errno($dbConnection)) {
                $_SESSION['signin'] = "Connection failed, Please try again later";
            } else {
                if (mysqli_num_rows($fetchUserResult) == 1) {
                    $userRecord = mysqli_fetch_assoc($fetchUserResult);
                    $dbPass = $userRecord['password'];

                    if (password_verify($password, $dbPass)) {
                        $_SESSION['userId'] = $userRecord['id'];
                        $_SESSION['avatar'] = $userRecord['avatar'];
                        $_SESSION['fname'] = $userRecord['username'];

                        if ($userRecord['isAdmin'] == 1) {
                            $_SESSION['userIsAdmin'] = true;
                        }else{
                            $_SESSION['userIsAdmin'] = false;
                        }

                        $_SESSION['signinSuccess'] = "Login successful";
                        header('Location:' . ROOT_URL . 'index.php');
                        die();
                    } else {
                        $_SESSION['signin'] = "Incorrect password";
                    }
                } else {
                    $_SESSION['signin'] = $username . " not registered. Please create a new account.";
                }
            }
        } catch (Exception $error) {
            $_SESSION['signin'] = "Login failed, Please try again later.<br>" . $error;
        }
    }

    if (isset($_SESSION['signin'])) {
        header('Location:' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('Location:' . ROOT_URL . 'signin.php');
    die();
}

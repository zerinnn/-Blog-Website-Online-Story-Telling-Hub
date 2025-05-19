<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';

if (isset($_SESSION['signupSuccess'])) {
    $message = $_SESSION['signupSuccess'];
    $messageClass = "success";
    unset($_SESSION['signupSuccess']);
}
if (isset($_SESSION['signin'])) {
    $message = $_SESSION['signin'];
    $messageClass = "error";
    unset($_SESSION['signin']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog Website</title>
    <meta name="title" content="Blog website" />
    <meta name="description" content="update in future" />

    <!-- favicon -->
    <link rel="shortcut icon" href="/images/Logo.png" type="image/x-icon" />

    <!-- external css -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+k  :wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- preload images -->
    <link rel="preload" as="image" href="images/pattern-2.svg" />
    <link rel="preload" as="image" href="images/pattern-3.svg" />
</head>

<body>
    <section class="section form_section">
        <div class="container form_sectionContainer">
            <h2>Sign In</h2>
            <?php if (isset($message)) : ?>
                <div class="alert-message <?= $messageClass ?>"><?= $message ?></div>
            <?php endif; ?>
            <form action="signinLogic.php" method="POST" enctype="multipart/form-data">
                <input type="text/email" name="usernameEmail" id="usernameEmail" placeholder="Enter username or email">
                <input type="password" name="pass" id="pass" placeholder="Enter password">
                <button type="submit" name="submit" class="btn btn-primary">Sign In</button>
                <small>Do not registered yet? <a href="<?= ROOT_URL ?>signup.php">Sign Up</a>
                </small>
            </form>
        </div>
    </section>
</body>

</html>
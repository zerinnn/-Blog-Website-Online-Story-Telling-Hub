<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'config/database.php';
if (isset($_SESSION['signup'])) {
    $message = $_SESSION['signup'];
    $messageClass = "error";
    unset($_SESSION['signup']);
} else if (isset($_SESSION['signupSuccess'])) {
    $message = $_SESSION['signupSuccess'];
    $messageClass = "success";
    unset($_SESSION['signupSuccess']);
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
            <h2>Sign Up</h2>
            <?php if (isset($message)) : ?>
                <div class="alert-message <?= $messageClass ?>"><?= $message ?></div>
            <?php endif; ?>

            <form action="<?= ROOT_URL ?>signupLogic.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="fname" id="fname" placeholder="Enter first name">
                <input type="text" name="lname" id="lname" placeholder="Enter last name">
                <input type="text" name="username" id="username" placeholder="Enter username">
                <input type="email" name="email" id="email" placeholder="Enter email">
                <input type="password" name="createPass" id="createPass" placeholder="Create password">
                <input type="password" name="confirmPass" id="confirmPass" placeholder="Confirm password">
                <div class="form-control">
                    <label for="avatar">Choose avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a>
                </small>
            </form>
        </div>
    </section>
</body>

</html>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';

if (!isset($_SESSION['userId'])) {
    header('Location: ' . ROOT_URL . 'signin.php');
    die();
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
    <link rel="shortcut icon" href="<?= ROOT_URL ?>images/logo.png" type="image/x-icon">

    <!-- external css -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+k  :wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- preload images -->
    <link rel="preload" as="image" href="images/pattern-2.svg" />
    <link rel="preload" as="image" href="images/pattern-3.svg" />
</head>

<body>
    <!-- header -->

    <header class="header" data-header>
        <div class="container">
            <div class="header-logo">
                <a href="#" class="logo">
                    <img src="<?= ROOT_URL ?>images/Logo.png" width="40" height="37" alt="Curious Chronicles logo" />
                </a>
                <div>
                    <p class="blog-title">Curious Chronicles</p>
                    <p class="blog-slogan">Sparking curiosity, one story at a time.</p>
                </div>
            </div>

            <nav class="navbar" data-navbar>
                <div class="navbar-top">
                    <a href="#" class="logo">
                        <img src="<?= ROOT_URL ?>images/Logo.png" width="40" height="37" alt="Curious Chronicles logo" />
                    </a>
                    <button class="nav-close-button" aria-label="close menu" data-nav-toggler>
                        <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
                    </button>
                </div>

                <ul class="navbar-list">
                    <li>
                        <a href="<?= ROOT_URL ?>#home" class="navbar-link hover-1" data-nav-toggler>Home</a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>#topics" class="navbar-link hover-1" data-nav-toggler>Topics</a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>#featured" class="navbar-link hover-1" data-nav-toggler>Featured Post</a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>#recent" class="navbar-link hover-1" data-nav-toggler>Recent Post</a>
                    </li>

                    <?php if (!isset($_SESSION['signinSuccess'])) : ?>
                        <li>
                            <a href="<?php ROOT_URL ?>signin.php" class="navbar-link hover-1 btn-primary" data-nav-toggler>Sign in</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['signinSuccess'])) : ?>
                        <li class="navbar-bottom">
                            <div class="profile-card">
                                <img src="images/<?= $_SESSION['avatar'] ?>" width="32" height="32" alt="change name with user" class="profile-banner" />

                                <div>
                                    <p class="card-title"> <?= "Hello ". $_SESSION['fname']; ?></p>
                                    <p class="card-subtitle">Welcome back!</p>
                                </div>
                            </div>

                            <ul class="link-list">
                                <li>
                                    <a href="<?= ROOT_URL ?>admin/index.php" class="navbar-bottom-link hover-1">Dashboard</a>
                                </li>

                                <li>
                                    <a href="<?= ROOT_URL ?>logout.php" class="navbar-bottom-link hover-1">Sign Out</a>
                                </li>
                            </ul>

                        </li>

                    <?php endif; ?>
                </ul>

            </nav>


            <button class="nav-open-btn" aria-label="open menu" data-nav-toggler="">
                <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
            </button>
        </div>
    </header>
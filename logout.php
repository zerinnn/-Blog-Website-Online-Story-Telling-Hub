<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';
session_destroy();
header('Location:' . ROOT_URL);
die();

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('ROOT_URL', 'http://localhost/Blog/');

?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}


if ($_SESSION['email'] !== 'admin@example.com') {
    die("Access denied. You are not an admin.");
}

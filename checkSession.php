<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$loggedInUser = $_SESSION['username'];
$loginameOfUser=$_SESSION['loginame'];
$userRole = $_SESSION['role'];
?>

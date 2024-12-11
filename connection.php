<?php
$servername = "webpagesdb.it.auth.gr:3306";
$username = "student4153";
$password = "student4153";
$dbname = "student4153";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
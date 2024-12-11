<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $Loginame = $_POST['username'];

        $sqlDeleteUser = "DELETE FROM user WHERE Loginame = '$Loginame'";
        $resultDelete = $conn->query($sqlDeleteUser);

        if ($resultDelete) {
            header("Location: index.php");
            exit();
        }
        else {
            echo 'Αποτυχία  διαγραφής χρήστη: ' . $conn->error;
        }
    }
}
$conn->close();
?>

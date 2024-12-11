<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('connection.php');

    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE Loginame='$input_username' AND Password='$input_password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['loginame']= $row['Loginame'];
        $_SESSION['username'] = $row['Όνομα'];
        $_SESSION['role'] = $row['Ρόλος'];
        header("Location: index.php");
        exit();
    } else {
        $error_message = 'Λάθος Loginame ή Κωδικός';
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Πιστοποίηση</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

<form action="" method="post">
    <h1>Πιστοποίηση</h1>
    <label for="username">Login:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <button type="submit" value="Login">Login</button>
</form>
</body>
</html>

<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $firstName = $_POST['Όνομα'];
        $lastName = $_POST['Επώνυμο'];
        $role = $_POST['Ρόλος'];

        $sqlUpdate = "UPDATE user SET Όνομα = '$firstName', Επώνυμο = '$lastName', Ρόλος = '$role' WHERE Loginame = '$username'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header('Location: index.php');
            exit();
        }
    }
}

if (isset($_GET['Loginame'])) {
    $username = $_GET['Loginame'];
    $sqlSelect = "SELECT * FROM user WHERE Loginame = '$username'";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['Όνομα'];
        $lastName = $row['Επώνυμο'];
        $role = $row['Ρόλος'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Επεξεργασία Χρήστη</title>
    <style>
        form {
            height: fit-content;
            width: fit-content;
            border: 3px solid #5C6BC0;
            padding: 20px;
            background: #5C6BC0;
            border-radius: 20px;
        }

        input, textarea {
            display: block;
            border: 2px solid #7986CB;
            width: 100%;
            padding: 10px;
            text-align: inherit;
            margin-bottom: 20px;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #E3F2FD;
            color: #333;
        }

        label {
            color: #ffffff;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .submit-btn {
            position: relative;
            flex: 6;
            margin: 30px;
            padding: 10px 15px;
            background: #7986CB;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background: #D1C4E9;
        }
    </style>
</head>
<body>

<div class="title">
    <h1>Επεξεργασία Χρήστη</h1>
</div>

<div class="container">
    <div id="side-menu"></div>
    <script>
        fetch('sidemenu.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('side-menu').innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
    </script>

    <div class="main-content">
        <form action="" method="post">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <label for="Όνομα">Όνομα:</label>
            <input type="text" id="Όνομα" name="Όνομα" value="<?php echo $firstName; ?>" required>
            <br>

            <label for="Επώνυμο">Επώνυμο:</label>
            <input type="text" id="Επώνυμο" name="Επώνυμο" value="<?php echo $lastName; ?>" required>
            <br>

            <label for="Ρόλος">Ρόλος:</label>
            <select id="Ρόλος" name="Ρόλος" required>
                <option value="Student" <?php echo ($role === 'Student') ? 'selected' : ''; ?>>Μαθητής</option>
                <option value="Tutor" <?php echo ($role === 'Tutor') ? 'selected' : ''; ?>>Καθηγητής</option>
            </select>
            <br>
            <br>

            <button class="submit-btn" type="submit">Ενημέρωση</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $newFirstName = $_POST['Όνομα'];
    $newLastName = $_POST['Επώνυμο'];
    $newLoginName = $_POST['username'];
    $newPassword = $_POST['password'];
    $newRole = $_POST['Ρόλος'];

    $checkUserQuery = "SELECT * FROM user WHERE Loginame = '$newLoginName'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
       $error_message = 'Το Loginame χρησιμοποιείται ήδη. Δοκιμάστε ξανά.';
    }
    else {
        $sqlAddUser = "INSERT INTO user (Όνομα, Επώνυμο, Loginame, Password, Ρόλος) VALUES ('$newFirstName', '$newLastName', '$newLoginName', '$newPassword', '$newRole')";

        if ($conn->query($sqlAddUser) === TRUE) {
            header('Location: index.php');
            exit();
        }
        else {
            echo 'Η προσθήκη χρήστη απέτυχε: ' . $conn->error;
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη Χρήστη</title>
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
    <h1>Προσθήκη Χρήστη</h1>
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
            <label for="Όνομα">Όνομα:</label>
            <input type="text" id="Όνομα" name="Όνομα" required>
            <br>

            <label for="Επώνυμο">Επώνυμο:</label>
            <input type="text" id="Επώνυμο" name="Επώνυμο" required>
            <br>

            <label for="username">Loginame:</label>
            <input type="text" id="username" name="username" required>
            <br>

            <label for="password">Κωδικός:</label>
            <input type="password" id="password" name="password" required>
            <br>

            <label for="Ρόλος">Ρόλος:</label>
            <select id="Ρόλος" name="Ρόλος" required>
                <option value="Student">Μαθητής</option>
                <option value="Tutor">Καθηγητής</option>
            </select>
            <br>
            <br>
            <br>
            <button class="submit-btn" type="submit" name="submit">Προσθήκη</button>
            <?php if (!empty($error_message)): ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
    </div>
</div>

</body>

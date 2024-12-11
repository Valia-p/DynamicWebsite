<?php
include ('connection.php');
include ('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'];
    $mainText = $_POST['mainText'];
    $currentDate = date('Y-m-d');

    $sql = "INSERT INTO announcement (date, theme, mainText) VALUES ('$currentDate', '$theme', '$mainText')";
    if ($conn->query($sql) === TRUE) {
        header('Location: announcement.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη Ανακοίνωσης</title>
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
    <h1>Προσθήκη Ανακοίνωσης</h1>
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
            <label for="theme">Θέμα:</label>
            <input type="text" id="theme" name="theme" required>

            <label for="mainText">Κείμενο:</label>
            <textarea id="mainText" name="mainText" rows="4" required></textarea>

            <button class="submit-btn" type="submit">Υποβολή</button>
        </form>
    </div>
</div>
</body>
</html>
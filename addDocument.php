<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $uploadDir = 'docFiles/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        $escapedFilePath = mysqli_real_escape_string($conn, $uploadFile);

        $sql = "INSERT INTO document (title, description, location) VALUES ('$title', '$description', '$escapedFilePath')";
        if ($conn->query($sql) === TRUE) {
            header('Location: document.php');
            exit();
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    else {
        echo "Σφάλμα μεταφόρτωσης αρχείου.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη Εγγράφου</title>
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
    <h1>Προσθήκη Εγγράφου</h1>
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

        <h2>Προσθήκη Νέου Εγγράφου</h2>
        <form id="document-form" action="" method="post" enctype="multipart/form-data">
            <label style="width: fit-content" for="title">Τίτλος Εγγράφου:</label>
            <input type="text" id="title" name="title" required>

            <label  style="width: fit-content" for="description">Περιγραφή Εγγράφου:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label  style="width: fit-content">Επέλεξε Αρχείο:</label>
            <input  type="file" name="file" required><br>

            <button class="submit-btn" type="submit">Υποβολή</button>
        </form>

    </div>
</div>
</body>
</html>

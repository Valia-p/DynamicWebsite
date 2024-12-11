<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documentId = $_POST['document_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $uploadDir = 'docFiles/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    if ($_FILES['file']['name'] !== "") {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $escapedFilePath = mysqli_real_escape_string($conn, $uploadFile);

            $sqlUpdate = "UPDATE document SET title = '$title', description = '$description', location = '$escapedFilePath' WHERE id = '$documentId'";
        }
        else {
            echo "Σφάλμα μεταφόρτωσης αρχείου.";
            exit();
        }
    }
    else {
        $sqlUpdate = "UPDATE document SET title = '$title', description = '$description' WHERE id = '$documentId'";
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        header('Location: document.php');
        exit();
    }
    else {
        echo "Σφάλμα ενημέρωσης αρχείου: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $documentId = $_GET['id'];
    $sqlSelect = "SELECT * FROM document WHERE id = '$documentId'";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $location = $row['location'];
    } else {
        echo "Δεν βρέθηκε έγγραφο.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Επεξεργασία Εγγράφου</title>
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
    <h1>Επεξεργασία Εγγράφου</h1>
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
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="document_id" value="<?php echo $documentId; ?>">

            <label style="width: fit-content" for="theme">Τίτλος:</label>
            <input type="text" id="title" name="title" value="<?php echo $title; ?>" required><br>

            <label for="mainText">Κείμενο:</label>
            <textarea id="description" name="description" rows="4" required><?php echo $description; ?></textarea><br>

            <label style="width: fit-content">Ήδη αναρτημένο αρχείο: <?php echo '<a href="' . $location . '">Download</a>';?></label><br><br>
            <label style="width: fit-content">Επέλεξε νέο αρχείο:</label>
            <input type="file" name="file"><br>

            <button class="submit-btn" type="submit">Ενημέρωση</button>
        </form>
    </div>
</div>
</body>
</html>

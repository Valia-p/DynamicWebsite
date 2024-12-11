<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goals = $_POST['goals'];
    $uploadDir = 'homeworkFiles/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);
    $deliverables = $_POST['deliverable'];
    $deadline = $_POST['deadline'];

    $goalsArray = explode(',', $goals);
    $deliverablesArray = explode(',', $deliverables);

    $goals = implode(', ', $goalsArray);
    $deliverables = implode(', ', $deliverablesArray);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        $escapedFilePath = mysqli_real_escape_string($conn, $uploadFile);

        $sql = "INSERT INTO homework (goals, location, deliverable, deadline) VALUES ('$goals', '$escapedFilePath', '$deliverables', '$deadline')";

        if ($conn->query($sql) === TRUE) {
            $announcementDate = date("Y-m-d");
            $announcementTheme = "Υποβλήθηκε η εργασία $conn->insert_id";
            $announcementText = "Η ημερομηνία παράδοσης της εργασίας είναι $deadline";

            $insertAnnouncementSQL = "INSERT INTO announcement (date, theme, mainText) VALUES ('$announcementDate', '$announcementTheme', '$announcementText')";
            $conn->query($insertAnnouncementSQL);

            header('Location: homework.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Σφάλμα μεταφόρτωσης αρχείου.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη νέας εργασίας</title>
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
    <h1>Προσθήκη νέας εργασίας</h1>
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
        <h2>Προσθήκη νέας εργασίας</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="goals">Στόχοι:</label>
            <input type="text" id="goals" name="goals" required>

            <label style="width: fit-content">Επέλεξε Αρχείο:</label>
            <input type="file" name="file" required>

            <label for="deliverable">Παραδοτέα:</label>
            <input type="text" id="deliverable" name="deliverable" required>

            <label style="width: fit-content" for="deadline">Ημερομηνίας Παράδοσης: </label>
            <input style="width: fit-content; margin-left: 20px;" type="date" id="deadline" name="deadline" required><br>

            <button class="submit-btn" type="submit">Υποβολή</button>
        </form>
        <br>
        <br>
        <h6 style="position:inherit;">Σημείωση: Παρακαλείσθε να διαχωρίσετε τα παραδοτέα και τους στόχους με κόμμα.</h6>
    </div>
</div>
</body>
</html>
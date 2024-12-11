<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $homeworkId = $_POST['homework_id'];
    $goals = $_POST['goals'];
    $deliverable = $_POST['deliverables'];
    $deadline = $_POST['deadline'];

    $uploadDir = 'homeworkFiles/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    if ($_FILES['file']['name'] !== "") {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $escapedFilePath = mysqli_real_escape_string($conn, $uploadFile);

            $sqlUpdate = "UPDATE homework SET goals = '$goals', deliverable = '$deliverable', deadline = '$deadline', location = '$escapedFilePath' WHERE id = '$homeworkId'";
        }
        else {
            echo "Σφάλμα μεταφόρτωσης αρχείου.";
            exit();
        }
    }
    else {
        $sqlUpdate = "UPDATE homework SET goals = '$goals', deliverable = '$deliverable', deadline = '$deadline' WHERE id = '$homeworkId'";
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        header('Location: homework.php');
        exit();
    }
    else {
        echo "Σφάλμα ενημέρωσης εργασίας: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $homeworkId = $_GET['id'];
    $sqlSelect = "SELECT * FROM homework WHERE id = '$homeworkId'";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $goals = $row['goals'];
        $deliverable = $row['deliverable'];
        $deadline = $row['deadline'];
        $location = $row['location'];
    } else {
        echo "Δεν βρέθηκε εργασία.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Επεξεργασία Εργασίας</title>
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

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #000;
        }

        .deadline-container {
            display: flex;
            align-items: center;
        }

        #deadline {
            flex: 1;
            margin-right: 10px;
        }

    </style>
</head>
<body>

<div class="title">
    <h1>Επεξεργασία Εργασίας</h1>
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
            <input type="hidden" name="homework_id" value="<?php echo $homeworkId; ?>">

            <label for="goals">Στόχοι:</label>
            <textarea id="goals" name="goals" rows="4" required><?php echo $goals; ?></textarea>
            <br>

            <label for="deliverables">Παραδοτέα:</label>
            <textarea id="deliverables" name="deliverables" rows="4" required><?php echo $deliverable; ?></textarea>

            <br>
            <div class="deadline-container">
                <label style="width: fit-content;" for="deadline">Ημερομηνία Παράδοσης:</label>
                <input style="width: fit-content" type="date" id="deadline" name="deadline" value="<?php echo $deadline; ?>" required>
            </div>

            <label style="width: fit-content;">Είδη επιλεγμένο αρχείο: <?php echo '<a href="' . $location . '">Download</a>';?></label>
            <br>
            <br>
            <label style="width: fit-content;">Επέλεξε Νέο Αρχείο:</label>
            <input type="file" name="file"><br>

            <button class="submit-btn" type="submit">Ενημέρωση</button>
        </form>
    </div>
</div>
</body>
</html>

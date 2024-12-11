<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_homework'])) {
        $homeworkId = $_POST['delete_homework'];

        $sqlSelectFile = "SELECT location FROM homework WHERE id = '$homeworkId'";
        $resultSelectFile = $conn->query($sqlSelectFile);

        if ($resultSelectFile->num_rows > 0) {
            $rowFile = $resultSelectFile->fetch_assoc();
            $fileLocation = $rowFile['location'];

            if (file_exists($fileLocation)) {
                unlink($fileLocation);
            }

            $sqlDelete = "DELETE FROM homework WHERE id = '$homeworkId'";
            if ($conn->query($sqlDelete) === TRUE) {
                header('Location: homework.php');
                exit();
            }
            else {
                echo "Σφάλμα διαγραφής εργασίας: " . $conn->error;
            }
        }
        else {
            echo "Δεν βρέθηκε εργασία.";
        }
    }
    elseif (isset($_POST['edit_homework'])) {
        $homeworkId = $_POST['edit_homework'];

        header("Location: edit_homework.php?id=$homeworkId");
        exit();
    }
}

$sql = "SELECT * FROM homework ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Εργασίες</title>
    <style>
        p {
            padding-left: 30px;
            padding-bottom: 10px;
        }

        span {
            font-style: italic;
            color: red;
        }

        .add-doc-btn {
            position: relative;
            flex: 6;
            margin: 20px;
            padding: 5px;
            background: rgba(18, 141, 236, 0.56);
            border-radius: 5px;
        }

        .add-doc-btn:hover {
            background: rgba(18, 141, 236, 0.87);
        }

        .edit-btn, .delete-btn {
            position: inherit;
            background: #ff6565;
            color: #fff;
            margin: 5px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .edit-btn:hover, .delete-btn:hover {
            background: #ff0000;
        }
    </style>
</head>
<body>

<div class="title">
    <h1>Εργασίες</h1>
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
        <?php
        if ($userRole == 'Tutor') {
            echo '<form action="addHomework.php" style="display: inline-block;">';
            echo '<button type="submit" class="add-doc-btn">Προσθήκη νέας εργασίας</button>';
            echo '</form>';
            echo '<hr>';
        }

        while ($row = $result->fetch_assoc()) {
            echo '<h2>Εργασία ' . $row['id'] . '</h2>';
            echo '<p style="font-style: italic">Στόχοι:</p>';
            echo '<ol>';
            $goals = explode(',', $row['goals']);
            foreach ($goals as $goal) {
                echo '<li>' . trim($goal) . '</li>';
            }
            echo '</ol>';
            echo '<p style="font-style: italic">Εκφώνηση:</p>';
            echo '<p style="padding-left: 65px">Κατεβάστε την εκφώνηση της εργασίας από <a href="' . $row['location'] . '">εδώ</a></p>';
            echo '<p style="font-style: italic">Παραδοτέα:</p>';
            echo '<ol>';
            $deliverables = explode(',', $row['deliverable']);
            foreach ($deliverables as $deliverable) {
                echo '<li>' . trim($deliverable) . '</li>';
            }
            echo '</ol>';
            echo '<p><span>Ημερομηνία παράδοσης</span>: ' . date("d/m/Y", strtotime($row['deadline'])) . '</p>';
            if($userRole == 'Tutor') {
                echo '<form action="" method="post" style="display: inline-block;">';
                echo '<input type="hidden" name="edit_homework" value="' . $row['id'] . '">';
                echo '<button type="submit" class="edit-btn">Επεξεργασία</button>';
                echo '</form>';
                echo '<form action="" method="post" style="display: inline-block;">';
                echo '<input type="hidden" name="delete_homework" value="' . $row['id'] . '">';
                echo '<button type="submit" class="delete-btn">Διαγραφή</button>';
                echo '</form>';
            }
            echo '<hr>';

        }
        ?>
    </div>
    <a href="#top" style="position: fixed; bottom: 20px; right: 20px; padding: 10px; background-color: #7986CB; color: #fff; text-decoration: none; border-radius: 5px;">Top</a>
</div>
</body>
</html>

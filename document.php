<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_document'])) {
        $documentId = $_POST['delete_document'];

        $sqlSelectFile = "SELECT location FROM document WHERE id = '$documentId'";
        $resultSelectFile = $conn->query($sqlSelectFile);

        if ($resultSelectFile->num_rows > 0) {
            $rowFile = $resultSelectFile->fetch_assoc();
            $fileLocation = $rowFile['location'];

            if (file_exists($fileLocation)) {
                unlink($fileLocation);
            }

            $sqlDelete = "DELETE FROM document WHERE id = '$documentId'";
            if ($conn->query($sqlDelete) === TRUE) {
                header('Location: document.php');
                exit();
            }
            else {
                echo "Αποτυχία διαγραφής εγγράφου: " . $conn->error;
            }
        } else {
            echo "Το έγγραφο δεν βρέθηκε.";
        }
    }
    elseif (isset($_POST['edit_document'])) {
        $documentId = $_POST['edit_document'];
        header("Location: edit_document.php?id=$documentId");
        exit();
    }
}

$sql = "SELECT * FROM document ORDER BY id DESC ";
$result = $conn->query($sql);
?>

<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Έγγραφα</title>
    <style>
        p{
            padding-left: 30px;
            padding-bottom: 20px;
        }
        a{
            padding-left: 30px ;
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
    <h1>Έγγραφα</h1>
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
            echo '<form action="addDocument.php" style="display: inline-block;">';
            echo '<button type="submit" class="add-doc-btn">Προσθήκη νέου εγγράφου</button>';
            echo '</form>';
            echo '<hr>';
        }

        while ($row = $result->fetch_assoc()) {
            echo '<h2>' . $row['title'].'</h2>';
            echo '<p><strong>Περιγραφή:</strong>' . $row['description'] . '</p>';
            echo '<a href="' . $row['location'] . '">Download</a>';
            echo '<br>';

            if($userRole=='Tutor') {
                echo '<form action="" method="post" style="display: inline-block;">';
                echo '<input type="hidden" name="edit_document" value="' . $row['id'] . '">';
                echo '<button type="submit" class="edit-btn">Επεξεργασία</button>';
                echo '</form>';
                echo '<form action="" method="post" style="display: inline-block; margin-left: 10px;">';
                echo '<input type="hidden" name="delete_document" value="' . $row['id'] . '">';
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

<?php
include('connection.php');
include('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_announcement'])) {
        $announcementId = $_POST['delete_announcement'];
        $sqlDelete = "DELETE FROM announcement WHERE id = '$announcementId'";
        if ($conn->query($sqlDelete) === TRUE) {
            header('Location: announcement.php');
            exit();
        }
        else {
            echo "Αποτυχία διαγραφής ανακοίνωσης: " . $conn->error;
        }
    }
    elseif (isset($_POST['edit_announcement'])) {
        $announcementId = $_POST['edit_announcement'];

        header("Location: edit_announcement.php?id=$announcementId");
        exit();
    }
}

$sql = "SELECT * FROM announcement ORDER BY date DESC";
$result = $conn->query($sql);
?>

<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Ανακοινώσεις</title>
    <style>
        p {
            padding-left: 30px;
            padding-bottom: 20px;
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

        .announcement {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="title">
    <h1>Ανακοινώσεις</h1>
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
            echo '<form action="addAnnouncement.php" style="display: inline-block;">';
            echo '<button type="submit" class="add-announcement-btn">Προσθήκη Ανακοίνωσης</button>';
            echo '</form>';

        echo '<hr>';
        }

        while ($row = $result->fetch_assoc()) {
            echo '<div class="announcement">';
            echo '<h2>Ανακοίνωση</h2>';
            echo '<p><strong>Ημερομηνία:</strong>' . date("d/m/Y", strtotime($row['date'])) .'</p>';
            echo '<p><strong>Θέμα:</strong>' . $row['theme'] . '</p>';
            if (preg_match('/εργασία/iu', $row['theme'])) {
                echo '<p>' . $row['mainText'] . ' .Έχει ανακοινωθεί στην ιστοσελίδα <a href="homework.php"> Εργασίες</a>.</p>';
            } else {
                echo '<p>' . $row['mainText'] . '</p>';
            }

            if ($userRole == 'Tutor') {
                echo '<form action="" method="post" style="display: inline-block;">';
                echo '<input type="hidden" name="edit_announcement" value="' . $row['id'] . '">';
                echo '<button type="submit" class="edit-btn">Επεξεργασία</button>';
                echo '</form>';
                echo '<form action="" method="post" style="display: inline-block; margin-left: 10px;">';
                echo '<input type="hidden" name="delete_announcement" value="' . $row['id'] . '">';
                echo '<button type="submit" class="delete-btn">Διαγραφή</button>';
                echo '</form>';
            }

            echo '<hr>';
            echo '</div>';
        }
        ?>
    </div>
    <a href="#top" style="position: fixed; bottom: 20px; right: 20px; padding: 10px; background-color: #7986CB; color: #fff; text-decoration: none; border-radius: 5px;">Top</a>
</div>
</body>
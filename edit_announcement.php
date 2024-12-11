<?php
include ('connection.php');
include ('checkSession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $announcementId = $_POST['announcement_id'];
    $theme = $_POST['theme'];
    $mainText = $_POST['mainText'];
    $date = date("Y-m-d");
    $sqlUpdate = "UPDATE announcement SET theme = '$theme', mainText = '$mainText', date='$date' WHERE id = '$announcementId'";

    if ($conn->query($sqlUpdate) === TRUE) {
        header('Location: announcement.php');
        exit();
    }
    else {
        echo "Σφάλμα ενημέρωσης ανακοίνωσης: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $announcementId = $_GET['id'];
    $sqlSelect = "SELECT * FROM announcement WHERE id = '$announcementId'";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $theme = $row['theme'];
        $mainText = $row['mainText'];
    }
    else {
        echo "Δεν βρέθηκε η ανακοίνωση.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Επεξεργασία Ανακοίνωσης</title>
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
    <h1>Επεξεργασία Ανακοίνωσης</h1>
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
            <input type="hidden" name="announcement_id" value="<?php echo $announcementId; ?>">

            <label for="theme">Θέμα:</label>
            <input type="text" id="theme" name="theme" value="<?php echo $theme; ?>" required>

            <label for="mainText">Κείμενο:</label>
            <textarea id="mainText" name="mainText" rows="4" required><?php echo $mainText; ?></textarea>

            <button class="submit-btn" type="submit">Ενημέρωση</button>
        </form>
    </div>
</div>
</body>
</html>
<?php
include('connection.php');
include('checkSession.php');

$tutorContent = '';

if (isset($_POST['edit_username'])) {
    $editUsername = $_POST['edit_username'];
    header("Location: edit_user.php?Loginame=$editUsername");
    exit();
}

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
    $userRole = $_SESSION['role'];
}

if ($userRole === 'Tutor') {
    $sqlSelectUsers = "SELECT * FROM user";
    $resultUsers = $conn->query($sqlSelectUsers);

    if ($resultUsers) {
        if ($resultUsers->num_rows > 0) {
            $tutorContent .= '<h2>Λίστα Χρηστών</h2>';
            $tutorContent .= '<form action="add_user.php" method="post">';
            $tutorContent .= '<button class="add-user-btn" type="submit">Προσθήκη Χρήστη</button>';
            $tutorContent .= '</form>';
            $tutorContent .= '<table>';
            $tutorContent .= '<tr><th>Όνομα</th><th>Επώνυμο</th><th>Loginame</th><th>Ρόλος</th><th>Action</th></tr>';

            while ($row = $resultUsers->fetch_assoc()) {
                $tutorContent .= '<tr>';
                $tutorContent .= '<td>' . htmlspecialchars($row['Όνομα']) . '</td>';
                $tutorContent .= '<td>' . htmlspecialchars($row['Επώνυμο']) . '</td>';
                $tutorContent .= '<td>' . htmlspecialchars($row['Loginame']) . '</td>';
                $tutorContent .= '<td>' . htmlspecialchars($row['Ρόλος']) . '</td>';
                $tutorContent .= '<td>';
                $tutorContent .= '<form action="" method="post" style="display: inline-block; margin-right: 5px;">';
                $tutorContent .= '<input type="hidden" name="edit_username" value="' . htmlspecialchars($row['Loginame']) . '">';
                $tutorContent .= '<button style="cursor: pointer;" type="submit">Επεξεργασία</button>';
                $tutorContent .= '</form>';
                if ($loggedInUser !== $row['Loginame']) {
                    $tutorContent .= '<form action="delete_user.php" method="post" style="display: inline-block;">';
                    $tutorContent .= '<input type="hidden" name="username" value="' . htmlspecialchars($row['Loginame']) . '">';
                    $tutorContent .= '<button style="cursor: pointer; margin-left: 10px;" type="submit">Διαγραφή</button>';
                    $tutorContent .= '</form>';
                }
                $tutorContent .= '</td>';
                $tutorContent .= '</tr>';
            }

            $tutorContent .= '</table>';
        }
        else {
            $tutorContent = 'Δεν βρέθηκαν χρήστες.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="el" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Αρχική Σελίδα</title>
</head>
<body>

<div class="title">
    <h1>Αρχική Σελίδα</h1>
</div>

<div class="container">
    <div id="side-menu">
        <script>
            fetch('sidemenu.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('side-menu').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        </script>
    </div>
    <div class="main-content">
        <p>Καλωσήρθες <?php echo htmlspecialchars($loggedInUser); ?>. Στον ιστότοπό μας για την εκμάθηση HTML! Εδώ θα βρείτε όλες τις πληροφορίες και τα εργαλεία που χρειάζεστε για να μάθετε HTML. Στην ενότητα "Ανακοινώσεις" θα ενημερώνεστε για σημαντικά νέα, στην "Επικοινωνία" θα βρείτε τρόπους να επικοινωνήσετε με τους καθηγητές, ενώ στα "Έγγραφα μαθήματος" θα βρείτε όλο το εκπαιδευτικό υλικό. Στην ενότητα "Εργασίες" σας περιμένουν ασκήσεις για να εφαρμόσετε τις γνώσεις σας.</p>

        <br>
        <img src="image1.jpg" alt="Περιγραφή της εικόνας">

        <?php
        if ($userRole === 'Tutor') {
            echo $tutorContent;
            echo '<div class="logout-container">
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Αποσύνδεση ' . htmlspecialchars($userRole) . '</button>
            </form>
          </div>';
        }

        if ($userRole === 'Student') {
        echo '<div class="logout-container-student">
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Αποσύνδεση ' . htmlspecialchars($userRole) . '</button>
            </form>
        </div>';
        }
        ?>

    </div>
</div>

</body>
</html>

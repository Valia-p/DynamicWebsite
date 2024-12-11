<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Επικοινωνία</title>
    <style>
        p {
            padding-left: 30px;
            padding-bottom: 20px;
        }

    </style>
</head>
<body>

<div class="title">
    <h1>Επικοινωνία</h1>
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
          include('connection.php');
          include ('checkSession.php');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!empty($loginameOfUser)) {
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];

                    $sql = "SELECT Loginame FROM user WHERE Ρόλος = 'Tutor'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tutorEmail = $row['Loginame'];
                            $headers = "From: $loginameOfUser";
                            if($tutorEmail != $loginameOfUser) {
                                mail($tutorEmail, $subject, $message, $headers);
                            }
                        }
                        echo '<br>';
                        echo '<p>Το e-mail στάλθηκε επιτυχώς στους καθηγητές από '.$loginameOfUser.'.</p>';
                    }
                    else {
                        echo '<p>Δεν βρέθηκαν καταχωρημένοι καθηγητές.</p>';
                    }
                    $conn->close();
                }
            }

//Υλοποίηση με PHPMailer
//        require 'Exception.php';
//        require 'PHPMailer.php';
//        require 'SMTP.php';
//
//        use PHPMailer\PHPMailer\PHPMailer;
//
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
//                $subject = $_POST['subject'];
//                $message = $_POST['message'];
//
//                $sql = "SELECT Loginame FROM user WHERE Ρόλος = 'Tutor'";
//                $result = $conn->query($sql);
//
//                if ($result->num_rows > 0) {
//                    $mail = new PHPMailer(true);
//                        //Πρέπει να έχετε ενεργοποιήσει την επιλογή "Enhanced Safe Browsing for your account" από το μενού "Security" στο gmail σας
//                        $mail->isSMTP();
//                        $mail->Host = "smtp.gmail.com";
//                        $mail->SMTPAuth = "true";
//                        $mail->SMTPSecure = "tls";
//                        $mail->Port="587";
//
//                        $mail->Username ="testforergasia@gmail.com"; //Your email
//                        $mail->Password = "simplepass"; //Your password
//
//
//                    $mail->setFrom("testforergasia@gmail.com"); //Your email
//                        while ($row = $result->fetch_assoc()) {
//                            $tutorEmail = $row['Loginame'];
//                            $mail->addAddress("$tutorEmail");
//                        }
//
//                        $mail->Subject = $subject;
//                        $mail->Body = $message;
//
//                        if($mail->Send()){
//                            echo '<p>Το email στάλθηκε επιτυχώς στους καθηγητές </p>';
//                        }
//                } else {
//                    echo '<p>Δεν βρέθηκαν καταχωρημένοι καθηγητές.</p>';
//                }
//
//                $conn->close();
//        }
//        ?>

        <h2>Αποστολή e-mail μέσω web φόρμας</h2>
        <form action="" method="post">
            <label style="color: black" for="subject">Θέμα:</label>
            <input type="text" id="subject" name="subject" required><br><br>

            <label style="color: black" for="message">Κείμενο:</label>
            <textarea id="message" name="message" rows="4" required></textarea><br><br>

            <button class="send-btn" type="submit">Αποστολή</button>
        </form>

        <hr>
        <h2>Αποστολή e-mail με χρήση e-mail διεύθυνσης</h2>
        <p>Εναλλακτικά μπορείτε να αποστείλετε e-mail στην παρακάτω διεύθυνση ηλεκτρονικού ταχυδρομείου <a href="mailto:tutor@csd.auth.test.gr">tutor@csd.auth.test.gr</a></p>
        <hr>
    </div>
</div>
</body>
</html>

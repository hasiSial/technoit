<?php
// Start with PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;

require_once './vendor/autoload.php';
// create a new object
$mail = new PHPMailer();
// configure an SMTP

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $from = $_POST['email'];
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $mail->isSMTP();
        $mail->Host = 'mail.technoit.digital';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@technoit.digital';
        $mail->Password = 'T3chno17!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        // $mail->addAddress('rizwansaleem70@gmail.com', 'TechnoIT Digital');
        $mail->addAddress('no-reply@technoit.digital', 'TechnoIT Digital');
        $mail->Subject = 'You got a new query!';
        // Set HTML 

        $message = "<p>Hello Admin,</p><br>";
        $message .= "<p>You got a new query. Please find the details below:</p>";
        $message .= "<p>Name: " . $name . "</p>";
        $message .= "<p>Email: " . $email . "</p>";
        $message .= "<p>Subject: " . $subject . "</p>";
        $message .= "<p>Message: " . $message . "</p>";
        $mail->isHTML(TRUE);
        $mail->Body = $message;

        // send the message
        if (!$mail->send()) {
            header('LOCATION: contact.html?status=false&message=' . $mail->ErrorInfo);
        } else {
            header('LOCATION: contact.html?status=true&message=Thank you for contacting us.');
        }
        //code...
    } catch (\Throwable $th) {
        header('LOCATION: contact.html?status=false&message=' . $th->getMessage());
    }
    exit;
}

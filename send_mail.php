<?php
echo '1';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';



    $status = 'failed';
    $status_message = '';

    try {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address!');
        }

        $mail = new PHPMailer(true);

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = '5dfae111f3d4d7';
        $mail->Password   = 'b62f75a7ed1cbe';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 2525;


        $mail->setFrom($email, $name);
        $mail->addAddress('suport@genzbit.com');

        $mail->isHTML(false);
        if (!empty($service)) {
            $mail->Subject = 'New Service from ' . $name;
            $mail->Body = "Name: $name\nEmail: $email\nService: $service\nMessage:\n$message";
        } elseif (!empty($vacancy)) {
            $mail->Subject = 'New Application from ' . $name;
            $mail->Body = "Name: $name\nEmail: $email\nVacancy: $vacancy\nMessage:\n$message";
        } else {
            $mail->Subject = 'New Contact from ' . $name;
            $mail->Body = "Name: $name\nEmail: $email\nWebsite: $website\nMessage:\n$message";
        }

        $mail->send();
        $status = 'success';
        $status_message = 'Form successfully submitted!';
    } catch (Exception $e) {
        $status_message = $e->getMessage();
    }

    header("Location: $url.php?status=$status&message=" . urlencode($status_message));
    exit();
}

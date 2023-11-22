<?php
namespace classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../lib/PHPMailer-master/src/PHPMailer.php';
require '../lib/PHPMailer-master/src/Exception.php';
require '../lib/PHPMailer-master/src/SMTP.php';

class Mail
{
    public function sendMail($name, $email)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                        // Send using SMTP
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
            $mail->SMTPAuth = true;               // Enable SMTP authentication
            $mail->Username = 'eventmanagementsystem.info@gmail.com'; // SMTP username
            $mail->Password = 'vfym hwkr hxbo ciua'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable explicit TLS encryption
            $mail->Port = 587;                // TCP port to connect to; use 587 for TLS

            // Recipients
            $mail->setFrom('eventmanagementsystem.info@gmail.com', 'Event Management System');
            $mail->addAddress($email, $name); // Add a recipient

            // Content
            $mail->isHTML(true);                    // Set email format to HTML
            $mail->Subject = 'Reset Account Password';
            $newlink = '<a href="http://localhost/project1/resetPassword.php?email='.$email.'"> <b>Click here</b></a> to Reset Your Password';
            $mail->Body = $newlink;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            // Your account password is reset and your new password is <b>pwd@123456</b>

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function updateUserPassword($con, $user_id, $password)
    {
        $query = "UPDATE user SET password=? WHERE user_name=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $password);
        $pstmt->bindValue(2, $user_id);
        $pstmt->execute();
    }
}





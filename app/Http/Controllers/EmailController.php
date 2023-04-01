<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;

class EmailController extends Controller
{
    public function sendEmail()
    {
        //SMTP server settings
        $smtpHost = 'smtp.gmail.com';
        $smtpUsername = 'your-gmail-address@gmail.com';
        $smtpAccessToken = 'your-oauth2-access-token';
        $smtpClientId = 'your-oauth2-client-id';
        $smtpClientSecret = 'your-oauth2-client-secret';
        $smtpRefreshToken = 'your-oauth2-refresh-token';
        $smtpPort = 465; //SSL encryption
        // $smtpPort = 587; //TLS encryption

        //Email settings
        $emailTo = 'recipient@example.com';
        $emailFrom = 'your-gmail-address@gmail.com';
        $emailSubject = 'Test email from Gmail SMTP server';
        $emailBody = 'This is a test email sent via Gmail SMTP server using PHP and OAuth2.';

        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        //SMTP server settings
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->OAuth2ClientId = $smtpClientId;
        $mail->OAuth2ClientSecret = $smtpClientSecret;
        $mail->OAuth2AccessToken = $smtpAccessToken;
        $mail->OAuth2RefreshToken = $smtpRefreshToken;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable SSL encryption
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption
        $mail->Port = $smtpPort;

        //Email settings
        $mail->setFrom($emailFrom);
        $mail->addAddress($emailTo);
        $mail->Subject = $emailSubject;
        $mail->Body = $emailBody;

        //Send email
        try {
            $mail->send();
            echo "Message sent!";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
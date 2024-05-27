<?php

require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail -> isSMTP();

$mail -> Host = 'smtp.gmail.com';
$mail -> Port = 587;
$mail -> SMTPAuth = true;
$mail -> SMTPSecure = 'tls';

$mail -> Username = 'mitlapiz@gmail.com';
$mail -> Password = 'sfajfxfddgdtmoim';
$mail -> setFrom('mitlapiz@gmail.com','MitLapizPrizren');
$mail -> addAddress('mitlapiz@gmail.com');
$mail -> addReplyTo('mitlapiz@gmail.com');

$mail -> isHTML(true);
$mail -> Subject = 'PHP Mailer Subject';
$mail->Body = '<h1> Harun Pasuli Prizren </h1>';

if (!$mail -> send()) {
    echo "Messages could not be sent!";
    echo 'Error: ' . $mail->ErrorInfo;
}

else {
    echo "Email has been sent!";
}

?>
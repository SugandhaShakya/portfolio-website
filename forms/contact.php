<?php
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $to = "shakyasugandha@gmail.com";
  $location = "mail form website";

  $headers = "From :" . $name . "\r\n" . "CC: smshakya@sugandhamanshakya.com.np  "

  $text = "You have received an email from ". $name."\r\n Email:" . $subject."\r\n Subject:" . "\r\n
  Message:" . $message;

  if($email!= NULL){
    mail($to, $subject, $txt, $headers);
  }

?>

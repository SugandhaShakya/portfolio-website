<?php
// Replace with your email address
$to = "shakyasugandha@gmail.com";
$subject = "New message from website contact form";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name = strip_tags(trim($_POST['name']));
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST['message']);
  $recaptcha_response = isset($_POST['recaptcha-response']) ? $_POST['recaptcha-response'] : '';

  if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please fill in all required fields and try again.";
    exit;
  }

  // Add your reCAPTCHA secret key here
  $recaptcha_secret = 'your-recaptcha-secret-key';

  // Verify reCAPTCHA response
  $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
  $recaptcha_data = [
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
  ];

  $recaptcha_options = [
    'http' => [
      'method' => 'POST',
      'content' => http_build_query($recaptcha_data),
      'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
    ]
  ];

  $recaptcha_context = stream_context_create($recaptcha_options);
  $recaptcha_result = json_decode(file_get_contents($recaptcha_url, false, $recaptcha_context));

  if (!$recaptcha_result->success) {
    http_response_code(400);
    echo "reCAPTCHA verification failed. Please try again.";
    exit;
  }

  $message_body = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";

  $headers = "From: $name <$email>";

  if (mail($to, $subject, $message_body, $headers)) {
    http_response_code(200);
    echo "OK";
  } else {
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message.";
  }

} else {
  http_response_code(403);
  echo "There was a problem with your submission, please try again.";
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname   = htmlspecialchars(strip_tags(trim($_POST["fname"] ?? "")));
    $lname   = htmlspecialchars(strip_tags(trim($_POST["lname"] ?? "")));
    $email   = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST["subject"] ?? "General Enquiry")));
    $message = htmlspecialchars(strip_tags(trim($_POST["message"] ?? "")));

    if (empty($fname) || empty($email) || empty($message)) {
        header("Location: contact.html?status=error");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.html?status=error");
        exit;
    }

    $to      = "hello@oniaz.pk"; // Change to your receiving email
    $subject_line = "ONIAZ Contact Form: " . $subject;

    $body  = "New message from the ONIAZ website contact form.\n\n";
    $body .= "Name:    " . $fname . " " . $lname . "\n";
    $body .= "Email:   " . $email . "\n";
    $body .= "Subject: " . $subject . "\n\n";
    $body .= "Message:\n" . $message . "\n";

    $headers  = "From: noreply@oniaz.pk\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $sent = mail($to, $subject_line, $body, $headers);

    if ($sent) {
        header("Location: contact.html?status=success");
    } else {
        header("Location: contact.html?status=error");
    }
    exit;
}
?>

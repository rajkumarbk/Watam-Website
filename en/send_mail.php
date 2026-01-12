<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recipient email
    $to = "info@watamglass.com";

    // Function to display a styled message
    function displayMessage($type, $text, $back_url) {
        $color = $type === 'success' ? '#4CAF50' : '#f44336';
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Form Status</title>
            <style>
                body {
                    background: #f4f7fa;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }
                .message-box {
                    background: #fff;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    padding: 40px;
                    text-align: center;
                    width: 90%;
                    max-width: 400px;
                }
                h2 { color: $color; margin-bottom: 15px; }
                p { color: #555; margin-bottom: 25px; }
                a.button {
                    display: inline-block;
                    background: $color;
                    color: #fff;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            <div class='message-box'>
                <h2>" . ucfirst($type) . "!</h2>
                <p>$text</p>
                <a href='$back_url' class='button'>Back to Website</a>
            </div>
        </body>
        </html>";
        exit;
    }

    // Get form fields safely
    $name    = trim($_POST["name"] ?? '');
    $email   = trim($_POST["email"] ?? '');
    $subject = trim($_POST["subject"] ?? '');
    $message = trim($_POST["message"] ?? '');

    // Validate
    if (!$name || !$email || !$subject || !$message) {
        displayMessage('error', 'Please fill in all required fields.', 'index.html#contact');
    }

    // Sanitize output
    $name    = htmlspecialchars($name);
    $email   = htmlspecialchars($email);
    $subject = htmlspecialchars($subject);
    $message = htmlspecialchars($message);

    // Email content
    $email_subject = "New Contact Form Submission: $subject";
    $email_body =
        "Name: $name\n" .
        "Email: $email\n\n" .
        "Message:\n$message\n";

    // Headers
    $headers  = "From: Watam Glass Website <no-reply@watamglass.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $email_subject, $email_body, $headers)) {
        displayMessage(
            'success',
            'Thank you! Your message has been sent successfully.',
            'index.html#contact'
        );
    } else {
        displayMessage(
            'error',
            'Sorry, something went wrong. Please try again later.',
            'index.html#contact'
        );
    }

} else {
    echo "Invalid request.";
}
?>

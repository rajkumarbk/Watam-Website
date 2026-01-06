<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recipient email
    $to = "watamglass@gmail.com";
    
    // Get and sanitize form data
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $phone   = htmlspecialchars(trim($_POST["phone"]));
    $message = htmlspecialchars(trim($_POST["message"]));
    
    // Email subject
    $email_subject = "New Contact Form Submission from Watam Auto Glass Website";
    
    // Email body
    $email_body = "You have received a new message from your website contact form.\n\n".
                  "Name: $name\n".
                  "Email: $email\n".
                  "Phone: $phone\n\n".
                  "Message:\n$message";
    
    // Email headers
    $headers  = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Function to display styled message
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
                    background: white; 
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
                    color: white; 
                    text-decoration: none;
                    padding: 10px 20px; 
                    border-radius: 5px; 
                    transition: background 0.3s ease; 
                }
                a.button:hover { 
                    background: " . ($type === 'success' ? '#45a049' : '#d32f2f') . "; 
                }
            </style>
        </head>
        <body>
            <div class='message-box'>
                <h2>" . ucfirst($type) . "!</h2>
                <p>$text</p>
                <a href='$back_url' class='button'>Back to Home</a>
            </div>
        </body>
        </html>
        ";
        exit;
    }
    
    // Send email
    if(mail($to, $email_subject, $email_body, $headers)) {
        displayMessage('success', 'Your message has been sent successfully. We'll get back to you soon!', 'index.html');
    } else {
        displayMessage('error', 'Oops! Something went wrong. Please try again later.', 'index.html');
    }
    
} else {
    echo "Invalid request.";
}
?>
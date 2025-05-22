<?php
session_start();
$host = 'localhost';
$dbname = 'monsite'; // <-- Your real database name
$username = 'root'; 
$password = ''; // No password for XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = trim($_POST['userInput']);

    if (empty($userInput)) {
        $message = "Please enter your email address.";
    } else {
        // Find user by email now
        $stmt = $pdo->prepare("SELECT id, email FROM utilisateur WHERE email = :email");
        $stmt->execute(['email' => $userInput]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // User found - generate token and expiration
            $token = bin2hex(random_bytes(50)); // secure token
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // token valid 1 hour

            // Save token and expiration in database
            $update = $pdo->prepare("UPDATE utilisateur SET reset_token = :token, reset_expires = :expires WHERE id = :id");
            $update->execute([
                'token' => $token,
                'expires' => $expires,
                'id' => $user['id']
            ]);

            // Build reset link
            $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;

            // Send email
            $to = $user['email'];
            $subject = "Password Reset Request";
            $emailMessage = "Hello,\n\n";
            $emailMessage .= "You requested a password reset.\n";
            $emailMessage .= "Please click the link below to reset your password:\n";
            $emailMessage .= $resetLink . "\n\n";
            $emailMessage .= "This link will expire in 1 hour.\n";
            $headers = "From: no-reply@yourdomain.com";

            // Uncomment to really send email
            // mail($to, $subject, $emailMessage, $headers);

            $message = "If an account with that email exists, a reset link has been sent.";
        } else {
            $message = "No account found with that email.";
        }
    }
}
?>

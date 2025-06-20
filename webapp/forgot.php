<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "killuazoldyck", "webapp");
    if (!$conn) {
        die(mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($user = mysqli_fetch_assoc($result)) {
        
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', time() + 3600); 
        
        $update = "UPDATE users SET reset_token = '$token', token_expiry = '$expiry' WHERE email = '$email'";
        mysqli_query($conn, $update);

        $reset_link = "http://localhost/reset.php?token=$token";
        echo "Password reset link: <a href='$reset_link'>$reset_link</a>";
    } else {
        echo "Email not found.";
    }
}
?>

<form method="post">
    <label>Email:</label>
    <input type="email" name="email" required />
    <input type="submit" value="Send reset link" />
</form>

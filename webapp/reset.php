<?php
if (!isset($_GET['token'])) {
    die("No token provided");
}

$conn = mysqli_connect("localhost", "root", "killuazoldyck", "webapp");
$token = mysqli_real_escape_string($conn, $_GET['token']);

$query = "SELECT * FROM users WHERE reset_token = '$token' AND token_expiry > NOW()";
$result = mysqli_query($conn, $query);

if ($user = mysqli_fetch_assoc($result)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = sha1($_POST['password']);

        $update = "UPDATE users SET password = '$new_password', reset_token = NULL, token_expiry = NULL WHERE id = " . $user['id'];
        mysqli_query($conn, $update);

        echo "Password updated successfully. <a href='login.php'>Login</a>";
        exit;
    }
} else {
    die("Invalid or expired token.");
}
?>

<form method="post">
    <label>New Password:</label>
    <input type="password" name="password" required minlength="6" />
    <input type="submit" value="Reset Password" />
</form>

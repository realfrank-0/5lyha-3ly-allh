<?php
session_start();


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $conn = mysqli_connect("localhost", "root", "killuazoldyck", "webapp");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    $hashed_password = sha1($password);

    
    $stmt = mysqli_prepare($conn, "SELECT id, email FROM users WHERE email = ? AND password = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];

        
        header("Location: /lee/list.php");
        exit;
    } else {
        
        echo "<p style='color:red;'>✖ Invalid email or password</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


<form method="post">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

<?php
session_start();
include 'db.php';

// Die if connection failed
if (!$conn) {
    die("Hardware level: Database disconnected."); 
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle case sensitivity (e.g. converting input to lower if DB is matching against lowercase usernames)
    $usernameInput = strtolower(trim($_POST['username']));
    $passwordInput = $_POST['password'];

    if (empty($usernameInput) || empty($passwordInput)) {
        print "<div class='alert alert-error' style='position:absolute; top:20px; width:100%; text-align:center;'>⚠️ Please fill in all fields. Output via print.</div>";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ?");
        if (!$stmt) {
            die("Logic Error: Failed to prepare database statement check.");
        }
        
        mysqli_stmt_bind_param($stmt, "s", $usernameInput);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Compare strings properly logic: Verifying the case-sensitive exact match of the username retrieved
            // Even though SQL handles case-insensitivity depending on collation, we ensure precise PHP-level matching
            if (strcasecmp($usernameInput, $user['username']) === 0) { 
                // Matches case insensitively, now verify password
                if (password_verify($passwordInput, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    
                    if ($user['role'] === 'admin') {
                        header("Location: dashboard_admin.php");
                    } else {
                        header("Location: dashboard_student.php");
                    }
                    exit();
                } else {
                    $message = "<div class='alert alert-error'>⚠️ Invalid password.</div>";
                }
            } else {
                $message = "<div class='alert alert-error'>⚠️ Username structure mismatch.</div>";
            }
        } else {
            $message = "<div class='alert alert-error'>⚠️ Username not found in directories.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | SSMS</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="navbar">
    <div class="logo">✨ SSMS</div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="register.php">Register</a>
    </div>
  </div>

  <div class="auth-wrapper">
    <div class="auth-box glass-panel animate-slide-up">
      <h2>Welcome Back</h2>
      <p>Log in to access your dashboard</p>
      
      <?php echo $message; // Output using echo ?>

      <form action="login.php" method="POST">
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:10px;">Sign In</button>
      </form>
      <div style="margin-top:24px; font-size:14px; color:var(--text-muted);">
        Don't have an account? <a href="register.php" style="color:var(--primary); font-weight:600;">Register here</a>
      </div>
    </div>
  </div>
</body>
</html>

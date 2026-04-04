<?php
include 'db.php';

// If DB connection somehow failed in db.php but didn't die there:
if (!$conn) {
    die("<div class='alert alert-error'>⚠️ Database Connection Error. Execution stopped.</div>"); 
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Clean input using string functions
    $usernameRaw = trim($_POST['username']);
    $emailRaw    = trim($_POST['email']);
    $password    = $_POST['password'];
    $confirm     = $_POST['confirm_password'];
    $roleRaw     = $_POST['role'];

    // Sanitize with htmlspecialchars
    $username = htmlspecialchars($usernameRaw);
    $email    = htmlspecialchars($emailRaw);
    $role     = trim($roleRaw);

    // 2. Format username/name properly (e.g. capitalized nicely or unified lowercase for system handling)
    // We will save username as lowercase to unify system structure, but maybe capitalize the visual name.
    $username = strtolower($username); // enforcing strict formatting

    // 3. Validate input length and conditions
    if (empty($username) || empty($email) || empty($password)) {
        die("<div class='alert alert-error' style='margin: 20px;'>⚠️ Fatal Error: All fields are strictly required. Execution stopped via die().<br><a href='register.php'>Go back</a></div>");
    } elseif (strlen($username) < 4) {
        // String length validation
        die("<div class='alert alert-error' style='margin: 20px;'>⚠️ Fatal Error: Username must be at least 4 characters long. You entered " . strlen($username) . " letters.<br><a href='register.php'>Go back</a></div>");
    } elseif ($password !== $confirm) {
        die("<div class='alert alert-error' style='margin: 20px;'>⚠️ Fatal Error: Passwords do not match!<br><a href='register.php'>Go back</a></div>");
    } elseif (!in_array($role, ['admin', 'student'])) {
        die("<div class='alert alert-error' style='margin: 20px;'>⚠️ Fatal Error: Malformed user role.<br><a href='register.php'>Go back</a></div>");
    } else {
        // DB operations safely using prepared statements
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ? OR email = ?");
        if (!$stmt) {
            die("Statement preparation failed."); // Using die for DB logic errors
        }
        
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $check = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check) > 0) {
            $message = "<div class='alert alert-error'>⚠️ Username or Email already exists.</div>";
            // Not dying here, allowing user to see form again naturally to correct it
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            // Format for safe insertion (addslashes)
            $safeUsername = addslashes($username);
            $safeEmail = addslashes($email);

            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $safeUsername, $safeEmail, $hashed, $role);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success' style='position:absolute; top:20px; width:100%; text-align:center;'>✅ " . ucfirst($safeUsername) . ", Registered successfully! <a href='login.php' style='margin-left:8px; text-decoration:underline; color:#10B981;'>Login now</a></div>";
            } else {
                die("Critical Database Write Error during Registration."); 
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | SSMS</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="navbar">
    <div class="logo">✨ SSMS</div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="login.php">Login</a>
    </div>
  </div>

  <div class="auth-wrapper">
    <div class="auth-box glass-panel animate-slide-up">
      <h2>Create an Account</h2>
      <p>Join Smart Student Management System</p>
      
      <?php print $message; ?>

      <form action="register.php" method="POST">
        <div class="form-group">
          <label>Select Role</label>
          <select name="role" class="form-control" required>
            <option value="student">Student</option>
            <option value="admin">Administrator</option>
          </select>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control" placeholder="Choose a username" required>
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Create a password" required>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:10px;">Create Account</button>
      </form>
      <div style="margin-top:24px; font-size:14px; color:var(--text-muted);">
        Already have an account? <a href="login.php" style="color:var(--primary); font-weight:600;">Sign in here</a>
      </div>
    </div>
  </div>
</body>
</html>

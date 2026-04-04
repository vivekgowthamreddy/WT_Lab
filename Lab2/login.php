<?php
session_start();
include "dbtest.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Both username and password are required";
    } else {
        $sql = "SELECT * FROM students
                WHERE name='$username' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Login successful - store user info in session
            $user = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            
            // Redirect to home/dashboard
            header("Location: home.html");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SSMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", system-ui, sans-serif;
        }

        body {
            background: #f8f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 400px;
        }

        .form-box {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: #222;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #4f46e5;
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #4f46e5;
            color: white;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .toggle-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .toggle-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        .toggle-link a:hover {
            text-decoration: underline;
        }

        .form-header {
            margin-bottom: 25px;
        }

        .form-header p {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 8px;
        }

        .error-message {
            color: #d32f2f;
            padding: 12px;
            background: #ffebee;
            border: 1px solid #ef5350;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="form-header">
                <h2 class="form-title">Login</h2>
                <p>Welcome back to SSMS</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <div class="toggle-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MongoDB Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { background-color: #001E2B; margin: 0; font-family: 'Poppins', sans-serif; color: #fff; }
    .navbar { padding: 20px 50px; background: rgba(0,255,100,0.1); display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #00ED64; }
    .logo { font-size: 24px; font-weight: 700; color: #00ED64; }
    .btn-logout { background: #E74C3C; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s; }
    .btn-logout:hover { background: #C0392B; }
    .dashboard-hero { padding: 80px 50px; text-align: center; }
    .dashboard-hero h1 { font-size: 48px; margin-bottom: 20px; }
    .dashboard-hero h1 span { color: #00ED64; }
    .dashboard-hero p { font-size: 18px; color: #aaa; max-width: 600px; margin: 0 auto; line-height: 1.6; }
    .collection-stats { margin-top: 50px; display: inline-block; padding: 30px; background: rgba(255,255,255,0.05); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="logo">MongoDB // Atlas Server Panel</div>
    <a href="logout.php" class="btn-logout">System Logout</a>
  </div>
  
  <div class="dashboard-hero">
    <h1>Welcome, <span><?php echo htmlspecialchars($_SESSION['user']); ?></span> 🎉</h1>
    <p>You have securely bypassed internal authentication mapping mathematically using a BSON document structure located natively directly inside the MongoDB backend collection array algorithm loop natively.</p>
    
    <div class="collection-stats">
      <h3 style="color:#00ED64; margin-bottom:10px;">Atlas Document Object Details</h3>
      <div style="font-family:monospace; color:#aaa; font-size:14px; text-align:left;">
        > Successfully mounted scalable NoSQL Database.<br>
        > Current Node instance routing safely.<br>
        > Hashing Protocol: BCRYPT Secure Payload Block.<br>
        > Identity Tracking Array: Active Native Pointer.
      </div>
    </div>
  </div>
</body>
</html>

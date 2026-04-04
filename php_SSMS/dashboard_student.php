<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
$firstLetter = strtoupper(substr($username, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Portal | SSMS</title>
  <link rel="stylesheet" href="dashboard.css" />
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <div class="logo-title">🎓 Student Portal</div>
    </div>
    <div class="nav-menu">
      <a href="#" class="nav-link active"><span class="nav-icon">🏠</span> My Dashboard</a>
      <a href="#" class="nav-link"><span class="nav-icon">📚</span> My Courses</a>
      <a href="#" class="nav-link"><span class="nav-icon">✅</span> Attendance</a>
      <a href="#" class="nav-link"><span class="nav-icon">📝</span> Assignments</a>
    </div>
    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="avatar"><?php echo $firstLetter; ?></div>
        <div>
          <div style="font-weight:600; font-size:14px;"><?php echo htmlspecialchars($username); ?></div>
          <div style="font-size:12px; color:var(--text-dim);">Student</div>
        </div>
      </div>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <div class="header-title">Welcome back, <?php echo htmlspecialchars($username); ?>! 👋</div>
      <div class="header-actions">
        <a href="logout.php"><button class="btn-logout">Logout</button></a>
      </div>
    </div>

    <div class="dashboard-container">
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon-wrap bg-indigo">📚</div>
          <div class="stat-value">6</div>
          <div class="stat-label">Active Courses</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap bg-green">✅</div>
          <div class="stat-value">95%</div>
          <div class="stat-label">Overall Attendance</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap bg-purple">🎯</div>
          <div class="stat-value">3.8</div>
          <div class="stat-label">Current GPA</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap bg-red">📝</div>
          <div class="stat-value">2</div>
          <div class="stat-label">Pending Assignments</div>
        </div>
      </div>

      <div class="panels-grid" style="grid-template-columns: 1fr 1fr;">
        <div class="panel">
          <div class="panel-header">
            <h2 class="panel-title">Upcoming Assignments</h2>
          </div>
          <div style="color:var(--text-dim); font-size:14px;">
            <div style="padding:16px; border:1px solid var(--border); border-radius:12px; margin-bottom:12px;">
              <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <strong style="color:#fff;">Web Technologies Lab 4</strong>
                <span style="color:#F87171;">Due Tomorrow</span>
              </div>
              <p>Create a full-stack login authentication system using PHP and MySQL.</p>
            </div>
            <div style="padding:16px; border:1px solid var(--border); border-radius:12px;">
              <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <strong style="color:#fff;">Database Systems Essay</strong>
                <span style="color:#34D399;">Due in 5 Days</span>
              </div>
              <p>Write an essay analyzing NoSQL vs SQL architectures.</p>
            </div>
          </div>
        </div>

        <div class="panel">
          <div class="panel-header">
            <h2 class="panel-title">Your Schedule Today</h2>
          </div>
          <div style="display:flex; flex-direction:column; gap:16px;">
            <div style="display:flex; gap:16px; align-items:center;">
              <div style="min-width:60px; font-weight:600; color:#818CF8;">09:00 AM</div>
              <div style="background:rgba(99,102,241,0.1); padding:12px 16px; border-radius:8px; width:100%;">Web Technologies (Room 302)</div>
            </div>
            <div style="display:flex; gap:16px; align-items:center;">
              <div style="min-width:60px; font-weight:600; color:#34D399;">11:30 AM</div>
              <div style="background:rgba(16,185,129,0.1); padding:12px 16px; border-radius:8px; width:100%;">Database Systems (Room 101)</div>
            </div>
            <div style="display:flex; gap:16px; align-items:center;">
              <div style="min-width:60px; font-weight:600; color:#C084FC;">02:00 PM</div>
              <div style="background:rgba(168,85,247,0.1); padding:12px 16px; border-radius:8px; width:100%;">Machine Learning (Lab 4)</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

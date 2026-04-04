<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
  <title>Admin Dashboard | SSMS</title>
  <link rel="stylesheet" href="dashboard.css" />
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <div class="logo-title">✨ SSMS Admin</div>
    </div>
    <div class="nav-menu">
      <a href="#" class="nav-link active"><span class="nav-icon">📊</span> Overview</a>
      <a href="#" class="nav-link"><span class="nav-icon">👥</span> Users & Roles</a>
      <a href="#" class="nav-link"><span class="nav-icon">📚</span> Courses</a>
      <a href="#" class="nav-link"><span class="nav-icon">⚙️</span> Settings</a>
    </div>
    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="avatar"><?php echo $firstLetter; ?></div>
        <div>
          <div style="font-weight:600; font-size:14px;"><?php echo htmlspecialchars($username); ?></div>
          <div style="font-size:12px; color:var(--text-dim);">Administrator</div>
        </div>
      </div>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <div class="header-title">Dashboard Overview</div>
      <div class="header-actions">
        <a href="logout.php"><button class="btn-logout">Logout</button></a>
      </div>
    </div>

    <div class="dashboard-container">
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon-wrap bg-indigo">👥</div>
          <div class="stat-value">1,248</div>
          <div class="stat-label">Total Students</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap bg-green">✅</div>
          <div class="stat-value">98.2%</div>
          <div class="stat-label">Avg Attendance</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap bg-purple">📚</div>
          <div class="stat-value">42</div>
          <div class="stat-label">Active Courses</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap bg-red">⚠️</div>
          <div class="stat-value">12</div>
          <div class="stat-label">Pending Issues</div>
        </div>
      </div>

      <div class="panels-grid">
        <div class="panel">
          <div class="panel-header">
            <h2 class="panel-title">Recent Enrollments</h2>
          </div>
          <table class="data-table">
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Course</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Johnson</td>
                <td>Web Technologies Lab</td>
                <td>Oct 24, 2026</td>
                <td><span class="status-badge status-active">Active</span></td>
              </tr>
              <tr>
                <td>Mark Smith</td>
                <td>Data Structures</td>
                <td>Oct 23, 2026</td>
                <td><span class="status-badge status-active">Active</span></td>
              </tr>
              <tr>
                <td>Sarah Lee</td>
                <td>Machine Learning Capstone</td>
                <td>Oct 21, 2026</td>
                <td><span class="status-badge status-active">Active</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="panel">
          <div class="panel-header">
            <h2 class="panel-title">System Activity</h2>
          </div>
          <div style="font-size:14px; color:var(--text-dim); display:flex; flex-direction:column; gap:16px;">
            <div style="display:flex; gap:12px; align-items:flex-start;">
              <div style="width:8px; height:8px; border-radius:50%; background:#10B981; margin-top:6px;"></div>
              <div>Database backup completed successfully.<br /><small style="color:#64748B;">2 mins ago</small></div>
            </div>
            <div style="display:flex; gap:12px; align-items:flex-start;">
              <div style="width:8px; height:8px; border-radius:50%; background:#6366F1; margin-top:6px;"></div>
              <div>New course (Cybersecurity) created.<br /><small style="color:#64748B;">1 hour ago</small></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

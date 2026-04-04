<?php
// DB Connection Test File - dbtest.php
include 'db.php';

if ($conn) {
    echo "<h2 style='color:green; font-family:sans-serif;'>✅ Database Connected Successfully!</h2>";
    echo "<p style='font-family:sans-serif;'>Connected to database: <strong>ssms_db</strong> on <strong>localhost</strong></p>";
} else {
    echo "<h2 style='color:red; font-family:sans-serif;'>❌ Connection Failed</h2>";
}
?>

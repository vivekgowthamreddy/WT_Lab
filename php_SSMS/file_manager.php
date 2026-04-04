<?php
// file_manager.php
session_start();
$uploadDir = "uploads/";

// Create folder if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Ensure the directory has permissions (only attempting)
@chmod($uploadDir, 0777); 

$message = "";

// 1. Handle Upload -> $_FILES and move_uploaded_file()
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $targetFile = $uploadDir . basename($_FILES["fileToUpload"]["name"]);
    
    // Basic PHP File Upload System
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        $message = "<div style='color:green; padding:10px; background:#e6ffe6; margin-bottom:15px; border-radius:5px;'>✅ File uploaded successfully: " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "</div>";
    } else {
        $message = "<div style='color:red; padding:10px; background:#ffe6e6; margin-bottom:15px; border-radius:5px;'>❌ Error uploading file. Directory permissions or file limits might restrict upload.</div>";
    }
}

// 2. Handle Delete -> unlink()
if (isset($_GET['delete'])) {
    $fileToDelete = $uploadDir . basename($_GET['delete']);
    // Security check to avoid path traversal
    if (file_exists($fileToDelete) && is_file($fileToDelete) && strpos($_GET['delete'], '..') === false) {
        if (unlink($fileToDelete)) {
            $message = "<div style='color:green; padding:10px; background:#e6ffe6; margin-bottom:15px; border-radius:5px;'>✅ File deleted.</div>";
        } else {
            $message = "<div style='color:red; padding:10px; background:#ffe6e6; margin-bottom:15px; border-radius:5px;'>❌ Error deleting file.</div>";
        }
    }
}

// 3. Handle Download -> PHP Headers mapped to memory
if (isset($_GET['download'])) {
    $fileToDownload = $uploadDir . basename($_GET['download']);
    if (file_exists($fileToDownload) && is_file($fileToDownload) && strpos($_GET['download'], '..') === false) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream'); // Forces generic binary stream
        header('Content-Disposition: attachment; filename="' . basename($fileToDownload) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileToDownload));
        readfile($fileToDownload); // Outputs to buffer natively
        exit;
    } else {
        $message = "<div style='color:red; padding:10px; background:#ffe6e6; margin-bottom:15px; border-radius:5px;'>❌ File not found.</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini File Manager</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; padding: 40px 20px; color:#333; }
        .manager-container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); max-width: 800px; margin: auto; }
        h2 { margin-top:0; color:#2c3e50; border-bottom: 2px solid #eee; padding-bottom: 15px;}
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th, td { border: 1px solid #edf2f7; padding: 14px; text-align: left; font-size:14px; }
        th { background-color: #f8fafc; font-weight: 600; color:#4a5568;}
        tr:hover { background-color:#f8fafc; }
        .btn { padding: 8px 14px; text-decoration: none; border-radius: 5px; color: #fff; display: inline-block; font-size: 13px; font-weight: 500; transition:0.3s; }
        .btn-blue { background: #3b82f6; border: none; }
        .btn-blue:hover { background: #2563eb; }
        .btn-red { background: #ef4444; }
        .btn-red:hover { background: #dc2626; }
        .upload-area { border: 2px dashed #cbd5e1; padding: 40px 20px; text-align: center; margin-bottom: 20px; border-radius:8px; background:#f8fafc; }
    </style>
</head>
<body>

<div class="manager-container">
    <h2>📁 Mini File Manager</h2>
    <?php echo $message; ?>

    <!-- Task 1: Upload Form -> enctype multipart/form-data is absolutely MANDATORY -->
    <div class="upload-area">
        <h3 style="margin-top:0; color:#475569;">Upload a New File</h3>
        <form action="file_manager.php" method="POST" enctype="multipart/form-data" style="display:flex; justify-content:center; gap:10px; align-items:center;">
            <input type="file" name="fileToUpload" required style="font-size:14px;">
            <button type="submit" class="btn btn-blue" style="cursor:pointer; font-size:14px;">Upload Payload</button>
        </form>
    </div>

    <!-- Directory Listing using scandir() & internal logic -->
    <h3 style="color:#2c3e50;">📂 Uploaded Files Repository</h3>
    <table>
        <tr>
            <th>File Name</th>
            <th>Size</th>
            <th>Last Modified</th>
            <th style="min-width: 160px;">Actions</th>
        </tr>
        <?php
        // Read directory safely mapping scandir()
        if (is_dir($uploadDir)) {
            $files = scandir($uploadDir);
            $hasFiles = false;
            
            foreach ($files as $file) {
                if ($file !== "." && $file !== "..") {
                    $filePath = $uploadDir . $file;
                    if (is_file($filePath)) {
                        $hasFiles = true;
                        
                        // Gathering mapped stats
                        $fSize = round(filesize($filePath) / 1024, 2); // File size represented cleanly in KB
                        $fTime = date("M d, Y H:i:s", filemtime($filePath)); // Modified time cleanly wrapped
                        $encodedFile = urlencode($file);

                        echo "<tr>";
                        echo "<td><strong>" . htmlspecialchars($file) . "</strong></td>";
                        echo "<td>{$fSize} KB</td>";
                        echo "<td><span style='color:#64748b; font-size:13px;'>🕒 {$fTime}</span></td>";
                        echo "<td>
                                <a href='file_manager.php?download={$encodedFile}' class='btn btn-blue'>Download</a>
                                <a href='file_manager.php?delete={$encodedFile}' class='btn btn-red' onclick='return confirm(\"Permanently delete this file?\");'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                }
            }
            if (!$hasFiles) {
                echo "<tr><td colspan='4' style='text-align:center; padding:20px; color:#94a3b8;'>No files uploaded yet.</td></tr>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>

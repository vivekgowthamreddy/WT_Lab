<?php
// file_functions_demo.php
echo "<h2 style='font-family:sans-serif;'>Task 2: Explore PHP File Functions</h2>";
echo "<div style='font-family:monospace; background:#f4f4f4; padding:20px; border-radius:5px;'>";

$testFile = "test_demo_file.txt";
$testDir = "demo_folder_123";

echo "<h3 style='color:#3498db;'>1. File Read/Write Operations (fopen, fwrite, fread, file_put_contents)</h3>";

// Write using fopen/fwrite
$fWrite = fopen($testFile, "w"); // Mode: w
if ($fWrite) {
    fwrite($fWrite, "Hello, this is a demonstration file created strictly using PHP file operations.\nSecond line included for array testing.\n");
    fclose($fWrite);
    echo "✅ Successfully mapped <b>fopen()</b>, <b>fwrite()</b>, and <b>fclose()</b>.<br>";
}

// Append using file_put_contents
file_put_contents($testFile, "Additional content injected seamlessly via file_put_contents().\n", FILE_APPEND);
echo "✅ Added content dynamically using <b>file_put_contents()</b>.<br><br>";

// Read utilizing fread
$fRead = fopen($testFile, "r");
if ($fRead) {
    echo "<b>> Read output via fread():</b><br>";
    echo nl2br(htmlspecialchars(fread($fRead, filesize($testFile)))) . "<br><br>";
    fclose($fRead);
}

// Read utilizing file_get_contents
echo "<b>> Read output via file_get_contents():</b><br>";
echo nl2br(htmlspecialchars(file_get_contents($testFile))) . "<br><br>";

// Read natively via file() mapped array
echo "<b>> Read output via file() (Array indexing):</b><br>";
$lines = file($testFile);
foreach($lines as $num => $line) {
    echo "Line {$num}: " . htmlspecialchars($line) . "<br>";
}

echo "<hr><h3 style='color:#3498db;'>2. File Information Gathering</h3>";
echo "<b>file_exists():</b> " . (file_exists($testFile) ? 'Yes, the node exists' : 'No') . "<br>";
echo "<b>filesize():</b> " . filesize($testFile) . " bytes<br>";
echo "<b>filetype():</b> " . filetype($testFile) . "<br>";
echo "<b>fileatime() (Last Accessed):</b> " . date("Y-m-d H:i:s", fileatime($testFile)) . "<br>";
echo "<b>filemtime() (Last Modified):</b> " . date("Y-m-d H:i:s", filemtime($testFile)) . "<br>";
echo "<b>filectime() (Inode Creation/Change):</b> " . date("Y-m-d H:i:s", filectime($testFile)) . "<br>";

// System level file checks (usually requires linux backend)
echo "<b>fileperms():</b> " . substr(sprintf('%o', fileperms($testFile)), -4) . "<br>";
echo "<b>fileowner():</b> UID " . fileowner($testFile) . "<br>";
echo "<b>filegroup():</b> GID " . filegroup($testFile) . "<br>";
echo "<b>fileinode():</b> INODE " . fileinode($testFile) . "<br>";

echo "<hr><h3 style='color:#3498db;'>3. File & Folder Management (Copy, Rename, Delete)</h3>";
echo "<b>is_file():</b> " . (is_file($testFile) ? "True mapping" : "False") . "<br>";

// Copy operation
copy($testFile, "copied_demo_file.txt");
echo "✅ Copied file triggered utilizing <b>copy()</b>.<br>";

// Rename operation
if (file_exists("copied_demo_file.txt")) {
    rename("copied_demo_file.txt", "renamed_demo_file.txt");
    echo "✅ File successfully renamed via <b>rename()</b>.<br>";
}

// Delete operation (unlink)
if (file_exists("renamed_demo_file.txt")) {
    unlink("renamed_demo_file.txt");
    echo "✅ Deleted specific node safely utilizing <b>unlink()</b>.<br>";
}

// Memory folder creation
if (!is_dir($testDir)) {
    mkdir($testDir);
    echo "✅ Native Directory created safely using <b>mkdir()</b>.<br>";
}
echo "<b>is_dir():</b> " . (is_dir($testDir) ? "True evaluation mapping" : "False") . "<br>";
if (is_dir($testDir)) {
    rmdir($testDir);
    echo "✅ Directory removed successfully using <b>rmdir()</b>.<br>";
}

echo "<hr><h3 style='color:#3498db;'>4. Directory Parsing (opendir, readdir, getcwd, chdir)</h3>";
echo "<b>getcwd():</b> Start working directory mapping: " . getcwd() . "<br>";

// Change dir and read
$originalDir = getcwd();
if (is_dir("uploads")) {
    chdir("uploads");
    echo "<b>chdir():</b> Changed specific active directory to -> uploads/.<br>";
    echo "<b>getcwd():</b> Current pointer is now natively at: " . getcwd() . "<br><br>";
    
    echo "<b>Using opendir() & readdir():</b><br>";
    $dh = opendir(".");
    while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != "..") {
            echo "-> " . $file . "<br>";
        }
    }
    closedir($dh);  // Close memory pointer
    echo "<br><b>closedir()</b> activated. Freeing pointers.<br>";
    chdir($originalDir); // Change back pointer gracefully
    echo "<b>chdir('..'):</b> Reverted to original root node.<br>";
} else {
    echo "<em>Please ensure 'uploads' directory exists to test parsing</em><br>";
}

echo "<hr><h3 style='color:#3498db;'>5. File Locking Logic (flock)</h3>";
$lockFile = fopen($testFile, "a");
if (flock($lockFile, LOCK_EX)) { // Exclusive lock trigger (locking out simultaneous DB writes)
    fwrite($lockFile, "Writing this string block while natively locked from all other scripts.\n");
    flock($lockFile, LOCK_UN); // Release native block
    echo "✅ Safely locked, mapped write actions, and cleanly unlocked utilizing <b>flock()</b> and <b>LOCK_EX</b>.<br>";
} else {
    echo "❌ Threading failed. Could not lock target structure.<br>";
}
fclose($lockFile);

echo "</div>";
?>

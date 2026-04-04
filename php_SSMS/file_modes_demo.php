<?php
// file_modes_demo.php
echo "<h2 style='font-family:sans-serif;'>Task 3: File Operation Modes Demonstration</h2>";
echo "<div style='font-family:sans-serif; background:#f9f9f9; padding:20px; border:1px solid #ddd; border-radius:5px;'>";

// Function safely deletes files if they previously existed internally from old tests
function clear_test_file($filename) {
    if (file_exists($filename)) {
        unlink($filename);
    }
}

clear_test_file("mode_test_w.txt");
clear_test_file("mode_test_a.txt");
clear_test_file("mode_test_x.txt");
clear_test_file("mode_test_r_plus.txt");
clear_test_file("mode_test_w_plus.txt");
clear_test_file("mode_test_a_plus.txt");
clear_test_file("mode_test_x_plus.txt");

// Provide a base file to read natively for 'r' mode
file_put_contents("mode_test_r.txt", "Initial base data mapped safely.");

echo "<ul style='line-height:2.0;'>";

// 1. Mode 'r'
echo "<li><b>Mode 'r' (Read Only)</b><br>";
echo "<span style='color:gray;'>Action: Opens file structure only for reading. Pointer mapped at structure start.</span><br>";
$f = fopen("mode_test_r.txt", "r");
echo "<b>Outcome Output:</b> " . fread($f, 100) . "</li><br>";
fclose($f);

// 2. Mode 'w'
echo "<li><b>Mode 'w' (Write Only, Truncates natively)</b><br>";
echo "<span style='color:gray;'>Action: Erases old data natively. Pointer placed at string start.</span><br>";
file_put_contents("mode_test_w.txt", "Old data to be destroyed perfectly.");
$f = fopen("mode_test_w.txt", "w");
fwrite($f, "New overwrite data securely injected.");
fclose($f);
echo "<b>Outcome Output:</b> " . file_get_contents("mode_test_w.txt") . "</li><br>";

// 3. Mode 'a'
echo "<li><b>Mode 'a' (Append Only)</b><br>";
echo "<span style='color:gray;'>Action: Pointer mapped exclusively to end of file structure. Does not erase data.</span><br>";
file_put_contents("mode_test_a.txt", "Hello");
$f = fopen("mode_test_a.txt", "a");
fwrite($f, " World, data mapped to end implicitly.");
fclose($f);
echo "<b>Outcome Output:</b> " . file_get_contents("mode_test_a.txt") . "</li><br>";

// 4. Mode 'x'
echo "<li><b>Mode 'x' (Exclusive Create / Write)</b><br>";
echo "<span style='color:gray;'>Action: Generates a brand new structural file. Will intentionally FAIL if structure already exists (prevents accidental overwrites).</span><br>";
$f = @fopen("mode_test_x.txt", "x");
if ($f) {
    fwrite($f, "Created safely natively.");
    fclose($f);
    echo "<b>Outcome Output 1:</b> File Created. <br>";
    // Attempting mapping again
    $f2 = @fopen("mode_test_x.txt", "x");
    echo "<b>Outcome Output 2:</b> " . ($f2 === false ? "Second attempt logically failed accurately because structure exists natively." : "") . "";
}
echo "</li><br>";

// 5. Mode 'r+'
echo "<li><b>Mode 'r+' (Read & Write)</b><br>";
echo "<span style='color:gray;'>Action: Pointer safely mapped at structure beginning. Does NOT erase content automatically. Enables reading & writing.</span><br>";
file_put_contents("mode_test_r_plus.txt", "ABCDEFGHIJKLM");
$f = fopen("mode_test_r_plus.txt", "r+");
fwrite($f, "123"); // Overwrites ONLY the first 3 structure bytes mapping
fclose($f);
echo "<b>Outcome Output:</b> " . file_get_contents("mode_test_r_plus.txt") . "</li><br>";

// 6. Mode 'w+'
echo "<li><b>Mode 'w+' (Read & Write, Truncates dynamically)</b><br>";
echo "<span style='color:gray;'>Action: Securely erases the structural file completely mapping pointer back to bytes 0. Allows Read & Write operations.</span><br>";
file_put_contents("mode_test_w_plus.txt", "Data that mathematically will be wiped.");
$f = fopen("mode_test_w_plus.txt", "w+");
fwrite($f, "New Fresh Read/Write block mapped.");
rewind($f); // Mathematically rewinding pointer back to block start to successfully read what we wrote
echo "<b>Outcome Output:</b> " . fread($f, 100) . "</li><br>";
fclose($f);

// 7. Mode 'a+'
echo "<li><b>Mode 'a+' (Read & Append)</b><br>";
echo "<span style='color:gray;'>Action: Pointer securely mapped dynamically to structure end. Retains previous data. Facilitates reading & explicit appending.</span><br>";
file_put_contents("mode_test_a_plus.txt", "Start");
$f = fopen("mode_test_a_plus.txt", "a+");
fwrite($f, " End block");
rewind($f); // Go back mathematically reading everything natively
echo "<b>Outcome Output:</b> " . fread($f, 100) . "</li><br>";
fclose($f);

// 8. Mode 'x+'
echo "<li><b>Mode 'x+' (Exclusive Create for Read & Write)</b><br>";
echo "<span style='color:gray;'>Action: Natively provisions a new structural file and permits combined Read & Write logic. Fails structurally if pre-exists.</span><br>";
$f = @fopen("mode_test_x_plus.txt", "x+");
if ($f) {
    fwrite($f, "Test safe data.");
    rewind($f);
    echo "<b>Outcome Output:</b> " . fread($f, 100) . "</li>";
    fclose($f);
}
echo "</ul></div>";
?>

<?php
// string_functions.php

echo "<h2>PART B - PHP String Functions</h2>";

$rawString = "   web technologies lab task   ";
echo "<b>Original Source String:</b> '" . $rawString . "'<br><br>";

// 1. Basic String Functions
echo "<b>strlen():</b> " . strlen($rawString) . " characters<br>";
echo "<b>str_word_count():</b> " . str_word_count($rawString) . " words<br>";
echo "<b>strrev():</b> " . strrev(trim($rawString)) . "<br>";

// 2. Substring & Trimming
echo "<b>trim():</b> '" . trim($rawString) . "'<br>";
echo "<b>ltrim():</b> '" . ltrim($rawString) . "'<br>";
echo "<b>rtrim():</b> '" . rtrim($rawString) . "'<br>";
echo "<b>substr(trimmed, 0, 3):</b> " . substr(trim($rawString), 0, 3) . "<br>"; 

// 3. Case Conversion
$cleanString = trim($rawString);
echo "<b>strtoupper():</b> " . strtoupper($cleanString) . "<br>";
echo "<b>strtolower():</b> " . strtolower("UPPERCASE WEB TEXT") . "<br>";
echo "<b>ucfirst():</b> " . ucfirst("hello world") . "<br>";
echo "<b>ucwords():</b> " . ucwords($cleanString) . "<br>";

// 4. Search & Replace
echo "<b>strpos('lab'):</b> Position " . strpos($cleanString, "lab") . "<br>";
echo "<b>str_replace('task', 'assignments'):</b> " . str_replace("task", "assignments", $cleanString) . "<br>";

// 5. String Comparison
$strA = "Admin";
$strB = "admin";
echo "<b>strcmp('Admin', 'admin'):</b> " . strcmp($strA, $strB) . " (Case-Sensitive, non-zero means not exact match)<br>";
echo "<b>strcasecmp('Admin', 'admin'):</b> " . strcasecmp($strA, $strB) . " (Case-Insensitive, 0 means match)<br>";

// 6. Special Characters & Security
$xssString = "<script>alert('hacked');</script>";
$quoteStr = "Student's Profile";

echo "<b>htmlspecialchars():</b> " . htmlspecialchars($xssString) . " (Browser safe rendering)<br>";
echo "<b>addslashes():</b> " . addslashes($quoteStr) . " (Escaped for DB)<br>";

?>

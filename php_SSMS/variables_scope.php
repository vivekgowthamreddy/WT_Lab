<?php
// variables_scope.php

echo "<h2>PART A - PHP Variables & Scope</h2>";

// 1. PHP Datatypes
echo "<h3>1. PHP Datatypes</h3>";
$stringVar = "Hello SSMS";               // string
$intVar = 2026;                          // integer
$floatVar = 98.75;                       // float
$boolVar = true;                         // boolean
$arrayVar = array("PHP", "SQL", "Web");    // array

echo "String: " . $stringVar . "<br>";
echo "Integer: " . $intVar . "<br>";
echo "Float: " . $floatVar . "<br>";
echo "Boolean: " . ($boolVar ? "True" : "False") . "<br>";
echo "Array[0]: " . $arrayVar[0] . "<br>";

// 2. Variable Scope
echo "<h3>2. Variable Scope Demonstrations</h3>";

// a. Local Scope
function demonstrateLocal() {
    $localVar = "I am accessible ONLY inside this function!";
    echo "<b>Local Scope:</b> " . $localVar . "<br>";
}
demonstrateLocal();

// b. Global Scope
$globalVar = "I am a global variable accessible anywhere via keywords.";

function demonstrateGlobal() {
    global $globalVar;
    echo "<b>Global Scope:</b> " . $globalVar . "<br>";
}
demonstrateGlobal();

// c. Static Scope (Testing multiple calls)
function demonstrateStatic() {
    static $staticCounter = 0;
    $staticCounter++;
    echo "<b>Static Scope (Counter):</b> " . $staticCounter . "<br>";
}
demonstrateStatic();
demonstrateStatic();
demonstrateStatic();

?>

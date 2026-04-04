<?php
require __DIR__ . '/vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    
    // Explicit Database Ping block structurally testing the active array MongoDB logic manually
    $dbs = $client->listDatabases();
    
    echo "<div style='font-family:sans-serif; background:#001E2B; color:#00ED64; padding:30px; border-radius:15px; text-align:center;'>
             <h1 style='font-size:40px;'>🌿 MongoDB Application Layer Connected Successfully!</h1>
             <p style='color:#fff;'>Your NoSQL daemon is appropriately mapped to PHP natively over port 27017 utilizing Composer's generic BSON MongoDB driver integration completely securely mathematically.</p>
          </div>";
} catch (Exception $e) {
    echo "<div style='font-family:sans-serif; padding:20px; font-size:18px; color:red; background:#ffebeb;'>
            ⚠️ <b>Failed completely mapping payload driver actively natively targeting local server MongoDB array safely!</b><hr> 
            Please explicitly ensure your manual <b>mongod.exe service</b> is actively running natively mapping port 27017 manually securely. <br><br>
            <i>Native Server Driver Error Exception Details Block:</i><br> " . $e->getMessage() . "
          </div>";
}
?>

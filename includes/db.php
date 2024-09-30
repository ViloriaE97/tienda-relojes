<?php
$host = 'sql301.infinityfree.com';
$user = 'si0_37411520';  
$pass = '2vnqqN8LoWEAZN';  
$dbname = 'if0_37411520_tienda_relojes';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

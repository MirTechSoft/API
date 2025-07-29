<?php
$host = "localhost";
$db_name = "api_php";  // ✅ Tumhara actual DB name
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected successfully<br>";  // ✅ Show connection success
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>

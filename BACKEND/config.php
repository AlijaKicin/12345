<?php
$host = '127.0.0.1';  // ili 'localhost'
$dbname = 'budget_buddy';
$username = 'root';    // ili korisničko ime za vašu bazu
$password = '';        // lozinka za vašu bazu, ako je postavljena

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



?>



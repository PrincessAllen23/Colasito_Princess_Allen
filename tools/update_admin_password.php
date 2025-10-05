<?php
// Temporary script to set the colasito@admin password to 'admin123'
if (!defined('PREVENT_DIRECT_ACCESS')) define('PREVENT_DIRECT_ACCESS', true);
require_once __DIR__ . '/../app/config/database.php';
$dbconf = $database['main'];
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $dbconf['hostname'], $dbconf['port'], $dbconf['database'], $dbconf['charset']);
try {
    $pdo = new PDO($dsn, $dbconf['username'], $dbconf['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $newpw = 'admin123';
    $hash = password_hash($newpw, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE students SET password = :hash, role = 'admin' WHERE email = 'colasito@admin'");
    $stmt->execute([':hash' => $hash]);
    echo "Updated rows: " . $stmt->rowCount() . "\n";

    // verify
    $stmt2 = $pdo->prepare("SELECT id,email,password FROM students WHERE email = 'colasito@admin' LIMIT 1");
    $stmt2->execute();
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "Found row id=" . $row['id'] . "\n";
        echo "Verifying... ";
        echo password_verify($newpw, $row['password']) ? "OK\n" : "FAIL\n";
    } else {
        echo "No row found for colasito@admin\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

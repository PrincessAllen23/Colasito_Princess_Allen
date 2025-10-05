<?php
// Temporary script to check admin rows in the students table
// Allow including guarded config files by defining the guard constant
if (!defined('PREVENT_DIRECT_ACCESS')) {
    define('PREVENT_DIRECT_ACCESS', true);
}
require_once __DIR__ . '/../app/config/database.php';

$dbconf = $database['main'];
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $dbconf['hostname'], $dbconf['port'], $dbconf['database'], $dbconf['charset']);
try {
    $pdo = new PDO($dsn, $dbconf['username'], $dbconf['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare("SELECT id,email,role,LENGTH(password) AS password_len,password FROM students WHERE email IN ('colasito@admin','admin@admin')");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) {
        echo "No matching admin rows found.\n";
    } else {
        foreach ($rows as $r) {
            echo "id: {$r['id']} | email: {$r['email']} | role: {$r['role']} | password_len: {$r['password_len']}\n";
            echo "password (raw): {$r['password']}\n";
            echo "----\n";
        }
    }
} catch (Exception $e) {
    echo "Error connecting to DB: " . $e->getMessage() . "\n";
}



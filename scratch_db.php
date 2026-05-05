<?php
require __DIR__ . '/app/core/Database.php';
// wait, config might be needed. Let's just create a PDO connection based on typical Laragon config.
try {
    $pdo = new PDO('mysql:host=localhost;dbname=idealis', 'root', '');
    $stmt = $pdo->query("SHOW COLUMNS FROM activities");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo $e->getMessage();
}

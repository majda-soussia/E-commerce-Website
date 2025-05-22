<?php
session_start();
require 'config.php'; // Inclure votre configuration DB

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantite), 0) as count FROM panier WHERE utilisateur_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch();
    
    echo json_encode(['count' => (int)$result['count']]);
} catch (PDOException $e) {
    echo json_encode(['count' => 0]);
}
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['total' => 0]);
    exit;
}

require 'config.php'; // Inclure votre configuration de base de données

$stmt = $pdo->prepare("SELECT SUM(p.quantite * pr.prix) as total 
                       FROM panier p
                       JOIN produits pr ON p.produit_id = pr.idp
                       WHERE p.utilisateur_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$result = $stmt->fetch();

echo json_encode(['total' => $result['total'] ?? 0]);
?>
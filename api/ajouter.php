<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
session_start();

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=monsite;charset=utf8", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Connexion échouée: ' . $e->getMessage()]);
    exit;
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Connectez-vous pour ajouter au panier']);
    exit;
}

// Récupérer les données
$produit_id = (int) $_POST['produit_id'];
$taille = $_POST['taille'] ?? 'unique';
$quantite = (int) $_POST['quantite'];

try {
    // Vérifier le stock
    $stmt = $pdo->prepare("SELECT stock FROM produits WHERE idp = ?");
    $stmt->execute([$produit_id]);
    $stock = $stmt->fetchColumn();

    if ($quantite > $stock) {
        echo json_encode(['status' => 'error', 'message' => 'Stock insuffisant']);
        exit;
    }

    // Vérifier l'existence dans le panier
    $stmt = $pdo->prepare("SELECT id, quantite FROM panierr WHERE user_id = ? AND produit_id = ? AND taille = ?");
    $stmt->execute([$_SESSION['user_id'], $produit_id, $taille]);
    $existing = $stmt->fetch();

    if ($existing) {
        $new_quantite = $existing['quantite'] + $quantite;
        $stmt = $pdo->prepare("UPDATE panierr SET quantite = ? WHERE id = ?");
        $stmt->execute([$new_quantite, $existing['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO panierr (user_id, produit_id, quantite, taille, date_ajout) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $produit_id, $quantite, $taille]);
    }

    // Mettre à jour le stock
    $new_stock = $stock - $quantite;
    $stmt = $pdo->prepare("UPDATE produits SET stock = ? WHERE idp = ?");
    $stmt->execute([$new_stock, $produit_id]);

    echo json_encode(['status' => 'success', 'message' => 'Ajouté au panier']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur: ' . $e->getMessage()]);
}
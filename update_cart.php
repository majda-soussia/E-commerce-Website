<?php
session_start();
header('Content-Type: application/json');

// Vérification des paramètres
if (!isset($_SESSION['user_id']) || !isset($_POST['id']) || !isset($_POST['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification du stock
    $stmt = $conn->prepare("SELECT p.quantite as cart_quantity, pr.stock 
                           FROM panierr p
                           JOIN produits pr ON p.produit_id = pr.idp
                           WHERE p.id = :id AND p.user_id = :user_id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Item not found']);
        exit();
    }
    
    if ($_POST['quantity'] > $result['stock']) {
        echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
        exit();
    }
    
    // Mise à jour de la quantité (en utilisant le bon nom de colonne 'quantile')
    $stmt = $conn->prepare("UPDATE panierr SET quantite = :quantity WHERE id = :id AND user_id = :user_id"); // ← Même adaptation ici
    $stmt->bindParam(':quantity', $_POST['quantity']);
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn = null;
    }
}
?>
<?php
session_start();
header('Content-Type: application/json');

// 1. Vérification des paramètres
if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
    exit();
}

// 2. Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Correction du nom de table (panierr → panier) et vérification du nom de colonne user_id
    $stmt = $conn->prepare("DELETE FROM panierr WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    
    // 4. Vérification du nombre de lignes affectées
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Article non trouvé ou ne vous appartenant pas',
            'debug' => [
                'user_id' => $_SESSION['user_id'],
                'item_id' => $_POST['id']
            ]
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur de base de données',
        'error' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn = null;
    }
}
?>
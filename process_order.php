<?php
session_start();

// 1. Validation CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Erreur de sécurité. Veuillez réessayer.";
    header("Location: myordre.php");
    exit();
}

// 2. Vérification de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 3. Configuration BDD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    
    $conn->beginTransaction();

    // 4. Calcul du total
    $stmt = $conn->prepare("
        SELECT p.prix, pan.quantite 
        FROM panierr pan
        JOIN produits p ON pan.produit_id = p.idp
        WHERE pan.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $cart_items = $stmt->fetchAll();

    $total = 0;
    foreach ($cart_items as $item) {
        $total += $item['prix'] * $item['quantite'];
    }

    // 5. Insertion commande principale
    $stmt = $conn->prepare("
        INSERT INTO commandes (
            user_id,
            adresse,
            ville,
            code_postal,
            telephone,
            payment_method,
            total,
            statut
        ) VALUES (?, ?, ?, ?, ?, ?, ?, 'en traitement')
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['adresse'],
        $_POST['ville'],
        $_POST['code_postal'],
        $_POST['telephone'],
        $_POST['payment_method'],
        $total
    ]);

    $commande_id = $conn->lastInsertId();

    // 6. Insertion des articles
    $stmt_items = $conn->prepare("
        INSERT INTO commande_items (
            commande_id,
            produit_id,
            quantite,
            prix_unitaire,
            taille
        )
        SELECT 
            :commande_id,
            pan.produit_id,
            pan.quantite,
            p.prix,
            pan.taille
        FROM panierr pan
        JOIN produits p ON pan.produit_id = p.idp
        WHERE pan.user_id = :user_id
    ");

    $stmt_items->execute([
        ':commande_id' => $commande_id,
        ':user_id' => $_SESSION['user_id']
    ]);

    // 7. Vidage du panier
    $stmt_delete = $conn->prepare("DELETE FROM panierr WHERE user_id = :user_id");
    $stmt_delete->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_delete->execute();

    $conn->commit();

    unset($_SESSION['csrf_token']);
    $_SESSION['commande_id'] = $commande_id;
    
    header("Location: confirmation.php");
    exit();

} catch (PDOException $e) {
    $conn->rollBack();
    error_log("Erreur traitement commande : " . $e->getMessage());
    $_SESSION['error'] = "Erreur lors du traitement : " . $e->getMessage();
    header("Location: myordre.php");
    exit();
}
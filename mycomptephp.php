<?php
session_start();
$host = 'localhost';
$db   = 'monsite';
$user = 'root'; // ou ton utilisateur MySQL
$pass = ''; // mot de passe MySQL
$charset = 'utf8mb4';
 // AJOUTE CETTE LIGNE


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);

    if (empty($email) || empty($password)) {
        header("Location: mycomptephp.php?error=1");
        exit();
    }

    // Préparer la requête
    $sql = "SELECT * FROM utilisateur WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifier le mot de passe
        if (password_verify($password, $user['motpasse'])) {
            // Mot de passe correct, créer une session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['role'] = $user['role'];

            // Rediriger vers la page d'accueil ou tableau de bord
            header("Location: bienve.php"); 
            exit();
        } else {
            // Mauvais mot de passe
            header("Location: mycomptephp.php?error=1");
            exit();
        }
    } else {
        // Email non trouvé
        header("Location: mycomptephp.php?error=1");
        exit();
    }
} else {
    header("Location: mycomptephp.php?error=1");
    exit();
}


?>

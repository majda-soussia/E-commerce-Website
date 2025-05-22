<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'monsite');     // Nom de votre base de données
define('DB_USER', 'root');       // Votre nom d'utilisateur MySQL
define('DB_PASS', '');           // Votre mot de passe MySQL

// Configuration des sessions


// Configuration du fuseau horaire
date_default_timezone_set('Europe/Paris');

// Configuration des erreurs (à désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fonction de connexion à la base de données
function getPDO() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            die("Une erreur de connexion est survenue.");
        }
    }

    return $pdo;
}

// Fonction de sécurisation des sorties
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
// Vérification des privilèges admin
function requireAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        $_SESSION['error'] = "Accès non autorisé";
        header('Location: mycompte.php');
        exit();
    }
}
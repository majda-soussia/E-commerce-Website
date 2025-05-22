<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Rediriger si l'utilisateur n'est pas admin
    header('Location: index.php');
    exit();
}
// Connexion BDD
require 'config.php';

// Récupérer les données sensibles
try {
    // Statistiques
    $stmt_users = $pdo->query("SELECT COUNT(*) FROM utilisateur");
    $total_users = $stmt_users->fetchColumn();

    // Dernières commandes
    $stmt_orders = $pdo->query("
        SELECT c.*, u.email 
        FROM commandes c
        JOIN utilisateur u ON c.user_id = u.id
        ORDER BY c.date_commande DESC 
        LIMIT 10
    ");
    $orders = $stmt_orders->fetchAll();

} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 20px;
            background: #f8f9fa;
        }
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'admin_nav.php'; ?>

    <div class="admin-container">
        <h1>Tableau de bord administrateur</h1>

        <div class="stat-box">
            <h2>Statistiques</h2>
            <p>Utilisateurs inscrits : <?= $total_users ?></p>
        </div>

        <div class="stat-box">
            <h2>Dernières commandes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['email']) ?></td>
                        <td><?= number_format($order['total'], 2, ',', ' ') ?> €</td>
                        <td><?= date('d/m/Y H:i', strtotime($order['date_commande'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
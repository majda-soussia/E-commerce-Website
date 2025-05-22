<?php if ($_SESSION['role'] === 'admin'): ?>
<nav class="admin-nav">
    <a href="admin_users.php">Gestion utilisateurs</a>
    <a href="myordre.php">Commandes</a>
    <a href="index.php">Produits</a>
</nav>
<?php endif; ?>
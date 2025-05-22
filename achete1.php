<?php

// Début de la session
session_start();
$isConnected = isset($_SESSION['user_id']);

// Connexion à la base de données
try {
    $host = 'localhost';
    $dbname = 'monsite';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// TRAITEMENT DE L'AJOUT AU PANIER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_panier'])) {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Veuillez vous connecter']);
        exit;
    }

    // Récupérer les données du formulaire
    $produit_id = intval($_POST['produit_id']);
    $taille = $_POST['taille'] ?? 'unique';
    $quantite = intval($_POST['quantite']);

    try {
        // Vérifier le stock disponible
        $stmt = $pdo->prepare("SELECT stock FROM produits WHERE idp = ?");
        $stmt->execute([$produit_id]);
        $stock = $stmt->fetchColumn();

        if ($quantite > $stock) {
            echo json_encode(['status' => 'error', 'message' => 'Stock insuffisant']);
            exit;
        }

        // Vérifier si l'article est déjà dans le panier
        $stmt = $pdo->prepare("SELECT id, quantite FROM panierr 
                             WHERE user_id = ? AND produit_id = ? AND taille = ?");
        $stmt->execute([$_SESSION['user_id'], $produit_id, $taille]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Mise à jour de la quantité
            $new_quantite = $existing['quantite'] + $quantite;
            $update = $pdo->prepare("UPDATE panierr SET quantite = ? WHERE id = ?");
            $update->execute([$new_quantite, $existing['id']]);
        } else {
            // Insertion d'un nouvel article
            $insert = $pdo->prepare("INSERT INTO panierr
                                    (user_id, produit_id, quantite, taille, date_ajout) 
                                    VALUES (?, ?, ?, ?, NOW())");
            $insert->execute([$_SESSION['user_id'], $produit_id, $quantite, $taille]);
        }

        // Mettre à jour le stock
        $new_stock = $stock - $quantite;
        $update_stock = $pdo->prepare("UPDATE produits SET stock = ? WHERE idp = ?");
        $update_stock->execute([$new_stock, $produit_id]);

        echo json_encode(['status' => 'success', 'message' => 'Article ajouté au panier']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur: ' . $e->getMessage()]);
    }
    exit;
}

// RÉCUPÉRATION DU PRODUIT POUR AFFICHAGE
$produit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($produit_id <= 0) {
    die("ID de produit invalide");
}

try {
    // Requête pour récupérer le produit
    $stmt = $pdo->prepare("SELECT *, 
                          IF(old_price IS NULL OR old_price = 0, NULL, old_price) AS old_price_display
                          FROM produits WHERE idp = ?");
    $stmt->execute([$produit_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        die("Produit non trouvé");
    }

    // Convertir les tailles en tableau
    $tailles = !empty($produit['taille']) ? explode(',', $produit['taille']) : [];

    // Convertir les thumbnails JSON en tableau
    $thumbnails = !empty($produit['thumbnails']) ? json_decode($produit['thumbnails'], true) : [];
    if (empty($thumbnails)) {
        // Si pas de thumbnails, utiliser l'image principale comme seule image
        $thumbnails = [$produit['image']];
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération du produit : " . $e->getMessage());
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="buy-t-shirt1.css" />
    <title><?= htmlspecialchars($produit['nomp']) ?></title>
</head>
<style>
    :root {
        --primary-color: #007bff;
        --secondary-color: #6c757d;
        --dark-color: #343a40;
        --light-color: #f8f9fa;
        --danger-color: #dc3545;
        --success-color: #28a745;
        --border-radius: 4px;
        --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }




    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }




    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #fff;
        position: relative;
        min-height: 100vh;
        padding-top: 80px;
    }




    /* Header Styles */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: #fff;
        box-shadow: var(--box-shadow);
        z-index: 1000;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;

    }




    .logo {
        text-decoration: none;
        color: var(--dark-color);
        font-size: 1.5rem;
        font-weight: 700;
    }




    .logo:hover {
        color: var(--primary-color);
    }




    .mobile-menu-button {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
    }




    .menu-icon {
        display: block;
        width: 25px;
        height: 3px;
        background-color: var(--dark-color);
        margin: 5px 0;
        transition: var(--transition);
    }




    /* Navigation */
    .nav {
        display: flex;
        align-items: center;

    }




    .nav-list {
        display: flex;
        list-style: none;
        align-items: center;
        gap: 1.5rem;
    }




    .nav-item {
        position: relative;
    }




    .nav-link,
    .submenu-toggle {
        text-decoration: none;
        color: var(--dark-color);
        font-weight: 500;
        padding: 0.5rem 0;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }




    .nav-link:hover,
    .submenu-toggle:hover {
        color: var(--primary-color);
    }




    .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        position: relative;
    }




    .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: var(--danger-color);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }




    /* Submenu */
    .submenu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        min-width: 200px;
        box-shadow: var(--box-shadow);
        border-radius: var(--border-radius);
        padding: 0.5rem 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: var(--transition);
        z-index: 100;
    }




    .has-submenu:hover .submenu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }




    .submenu-link {
        display: block;
        padding: 0.5rem 1rem;
        color: var(--dark-color);
        text-decoration: none;
        transition: var(--transition);
    }




    .submenu-link:hover {
        background-color: var(--light-color);
        color: var(--primary-color);
    }




    /* Search Form */
    .search-form {
        display: flex;
        align-items: center;
        position: relative;
    }




    .search-form input {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 2rem;
        width: 200px;
        transition: var(--transition);
    }




    .search-form input:focus {
        outline: none;
        border-color: var(--primary-color);
        width: 250px;
    }




    .search-form button {
        background: none;
        border: none;
        position: absolute;
        right: 10px;
        cursor: pointer;
    }








    .header a {
        text-decoration: none;
        color: #333;
    }




    .header a:hover {
        color: #007bff;
    }




    /* Footer Styles */
    .footer,
    .footer-container {
        background-color: #2c3e50 !important;
        /* Ensure all sections have the same color */
        color: #ecf0f1;
        /* Ensure text remains visible */
    }

    /* Footer Styles */
    .footer {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding-top: 3rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }




    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 3rem;
    }




    .footer-section {
        margin-bottom: 2rem;
    }




    .footer-heading {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }




    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #e74c3c;
    }




    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }




    .footer-links li {
        margin-bottom: 0.8rem;
    }




    .footer-link {
        color: #bdc3c7;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.95rem;
    }




    .footer-link:hover {
        color: #e74c3c;
        padding-left: 5px;
    }




    .social-links {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }




    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }




    .social-link:hover {
        background-color: #e74c3c;
        transform: translateY(-3px);
    }




    .social-link img {
        filter: brightness(0) invert(1);
    }




    .newsletter {
        margin-top: 2rem;
    }




    .newsletter-title {
        font-size: 1rem;
        margin-bottom: 1rem;
        color: #fff;
    }




    .newsletter-form {
        display: flex;
        max-width: 300px;
    }




    .newsletter-form input {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 4px 0 0 4px;
        font-size: 0.9rem;
    }




    .newsletter-form button {
        padding: 0 1.5rem;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }




    .newsletter-form button:hover {
        background-color: #c0392b;
    }




    .footer-bottom {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 1.5rem 0;
        margin-top: 3rem;
    }




    .footer-bottom-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }




    .copyright {
        font-size: 0.85rem;
        color: #bdc3c7;
        margin-bottom: 1rem;
    }




    .legal-links {
        display: flex;
        gap: 1.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }




    .legal-links a {
        color: #bdc3c7;
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.3s ease;
    }




    .legal-links a:hover {
        color: #e74c3c;
    }








    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .footer-section:last-child {
            grid-column: span 2;
        }

        .newsletter-form {
            max-width: 100%;
        }

        .footer-section:last-child {
            grid-column: span 1;
        }

        .legal-links {
            flex-direction: column;
            gap: 0.5rem;
        }

        .social-media {
            justify-content: center;
        }

        .account-container {
            padding: 1rem;
        }

        .account-form {
            padding: 1.5rem;

        }
    }

    .aside {
        display: flex;
    }

    .aside img {
        margin: 50px 50px;
        width: 550px;
        border-radius: 4px;
    }

    .aside del {
        text-decoration: none;
    }




    .achet select {
        width: 150px;
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px;

    }

    .achet h3 {
        display: flex;
        align-items: center;
        gap: 10px;

    }

    .achet h2 {
        margin-top: 80px;
    }






    .old-price {
        text-decoration: line-through;
        color: #888;
        transition: color 0.3s ease;
    }




    .new-price {
        color: red;
        font-weight: bold;
        transition: color 0.3s ease;
    }




    .old-price:hover {
        color: rgb(232, 153, 153);
    }




    .new-price:hover {
        color: darkred;
    }

    .flex {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .achet input[type="number"],
    .achet input[type="submit"] {
        height: 40px;
        border-radius: 5px;
    }




    .achet input[type="number"] {
        width: 60px;
        text-align: center;
        border: 1px solid #ccc;
    }




    .achet input[type="submit"] {
        width: 300px;
        margin: 30px;
        border: none;
        background-color: #f8a932;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }




    .achet input[type="submit"]:hover {
        background-color: #e0882b;
    }

    .livraison {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 500px;
        padding: 15px;
        background-color: #f8f8f8;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }




    .livraison img {
        width: 40px;
        height: 40px;
    }




    .livraison span {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }




    .livraison a {
        color: black;
        text-decoration: underline;
    }




    .livraison a:hover {
        text-decoration: none;
    }

    .product-gallery {
        display: flex;
        align-items: center;
        gap: 20px;
        margin: 40px;

    }

    .thumbnails {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .thumbnails img {
        width: 80px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
        transition: border 0.3s;
        margin-bottom: 5px;


    }



    .thumbnails img:hover,
    .thumbnails img.active {
        border: 2px solid orange;
    }



    .main-image-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .main-image img {
        width: 400px;
        height: 600px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .arrow {
        font-size: 40px;
        cursor: pointer;
        color: #444;
        transition: color 0.3s;
        user-select: none;
    }

    .arrow:hover {
        color: orange;
    }

    mobile-menu-button.open .menu-icon:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }

    .mobile-menu-button.open .menu-icon:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-button.open .menu-icon:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
    }
</style>

<body>
    <!-- Header Section -->
    <header class="header">
        <a class="logo" href="index.php">
            <h1>My Shop</h1>
        </a>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-button" aria-label="Toggle navigation menu">
            <span class="menu-icon"></span>
            <span class="menu-icon"></span>
            <span class="menu-icon"></span>
        </button>

        <nav class="nav">
            <ul class="nav-list">
                <li class="nav-item has-submenu">
                    <button class="nav-link submenu-toggle">Women</button>
                    <ul class="submenu">
                        <li><a href="t_shirtfemme.php" class="submenu-link">T-shirts</a></li>
                        <li><a href="pantallon_femme.php" class="submenu-link">Pants</a></li>
                        <li><a href="robefemme.php" class="submenu-link">Dresses</a></li>
                        <li><a href="jupefemme1.php" class="submenu-link">Skirts</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <button class="nav-link submenu-toggle">Men</button>
                    <ul class="submenu">
                    <li><a href="t_shirthomme.php" class="submenu-link">T-shirts</a></li>
                        <li><a href="pantallon_homme.php" class="submenu-link">Pants</a></li>
                        <li><a href="suitehomme.php" class="submenu-link">Suits</a></li>
                        <li><a href="coatshomme.php" class="submenu-link">Coats</a></li>
                    </ul>
                </li>

                <li class="nav-item search-item">
                    <form role="search" class="search-form">
                        <input type="search" placeholder="Search products..." aria-label="Search products">
                        <button type="submit" aria-label="Search">
                            <img src="imges/recher.png" alt="" width="25" height="15">
                        </button>
                    </form>
                </li>

                <li class="nav-item icon-item">
                    <a href="favoris.php" class="nav-icon" aria-label="Wishlist">
                        <img src="imges/heart.png" alt="Wishlist" width="25" height="15">
                    </a>
                </li>

                <li class="nav-item icon-item">
                    <a href="panier.php" class="nav-icon" aria-label="Shopping cart">
                        <img src="imges/panier.png" alt="Cart" width="25" height="15">
                        <span class="cart-count">0</span>
                    </a>
                </li>

                <li class="nav-item icon-item">
                    <a href="<?php echo $isConnected ? 'bienve.php' : 'mycompte.php'; ?>" class="nav-icon"
                        aria-label="My account">
                        <img src="imges/compte.png" alt="Account" width="25" height="15">
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <aside class="aside">
        <div class="product-gallery">
            <div class="thumbnails">
                <?php foreach ($thumbnails as $index => $thumb): ?>
                    <img class="thumb <?= $index === 0 ? 'active' : '' ?>" src="<?= htmlspecialchars($thumb) ?>"
                        alt="Mini <?= $index + 1 ?>">
                <?php endforeach; ?>
            </div>

            <div class="main-image-wrapper">
                <span class="arrow left" id="prev">&#8249;</span>
                <div class="main-image">
                    <img id="mainImg" src="<?= htmlspecialchars($thumbnails[0]) ?>"
                        alt="<?= htmlspecialchars($produit['nomp']) ?>">
                </div>
                <span class="arrow right" id="next">&#8250;</span>
            </div>
        </div>

        <div class="achet">
            <h2><?= htmlspecialchars($produit['nomp']) ?></h2>
            <hr>
            <h3>
                <?php if (!empty($produit['old_price_display'])): ?>
                    <s class="old-price">$<?= number_format($produit['old_price_display'], 2) ?></s>
                <?php endif; ?>
                <ins class="new-price">$<?= number_format($produit['prix'], 2) ?></ins>
            </h3>
            <p><?= htmlspecialchars($produit['descp']) ?></p>

            <form action="api/ajouter.php" method="POST" id="panierForm">
                <input type="hidden" name="produit_id" value="<?= htmlspecialchars($produit['idp']) ?>">

                <?php if (!empty($tailles)): ?>
                    <div class="size-selector">
                        <label for="taille">Taille:</label>
                        <select name="taille" id="taille" required>
                            <?php foreach ($tailles as $t): ?>
                                <option value="<?= htmlspecialchars(trim($t)) ?>">
                                    <?= htmlspecialchars(trim($t)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="taille" value="unique">
                <?php endif; ?>

                <div class="quantity-selector">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" id="quantite" min="1" max="<?= (int) $produit['stock'] ?>"
                        value="1" required>
                    <span class="stock-disponible">(<?= (int) $produit['stock'] ?> disponibles)</span>
                </div>

                <button type="submit" class="add-to-cart" id="button1">
                    AJOUTER AU PANIER
                </button>
            </form>

            <p class="livraison">
                <img src="imges/camion.png" alt="camion">
                <span id="livraison-message">Livraison gratuite à partir de 189 dinars</span>
                <a href="#">Livraison</a>
            </p>
        </div>
    </aside>
    <!---partie l5ra fi page fix  -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3 class="footer-heading">Help</h3>
                <ul class="footer-links">
                    <li><a href="mycompte.php" class="footer-link">Login</a></li>
                    <li><a href="créecompte.php" class="footer-link">Create an Account</a></li>
                    <li><a href="#" class="footer-link">My Cart</a></li>
                    <li><a href="#" class="footer-link">Favorites</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Shop</h3>
                <ul class="footer-links">
                    <li><a href="#" class="footer-link">Men</a></li>
                    <li><a href="#" class="footer-link">Women</a></li>
                    <li><a href="#" class="footer-link">Sales</a></li>
                    <li><a href="#" class="footer-link">New Arrivals</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Contact</h3>
                <ul class="footer-links">
                    <li><a href="email.php" class="footer-link">Email</a></li>
                    <li><a href="phone.php" class="footer-link">Phone</a></li>
                    <li><a href="Customer Service.php" class="footer-link">Customer Service</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Social Media</h3>
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=100076255674035" class="social-link" aria-label="Facebook">
                        <img src="imges/fb.png" alt="Facebook" width="24" height="24">
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <img src="imges/instg.png" alt="Instagram" width="24" height="24">
                    </a>
                    <a href="#" class="social-link" aria-label="WhatsApp">
                        <img src="imges/wattsap.png" alt="WhatsApp" width="24" height="24">
                    </a>
                    <a href="#" class="social-link" aria-label="LinkedIn">
                        <img src="imges/linkdin.png" alt="LinkedIn" width="24" height="24">
                    </a>
                    <a href="#" class="social-link" aria-label="Snapchat">
                        <img src="imges/snap.png" alt="Snapchat" width="24" height="24">
                    </a>
                    <a href="#" class="social-link" aria-label="YouTube">
                        <img src="imges/youtube.png" alt="YouTube" width="24" height="24">
                    </a>
                </div>

                <div class="newsletter">
                    <h4 class="newsletter-title">Newsletter</h4>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <p class="copyright">&copy; 2025 My Shop. All rights reserved.</p>
                <ul class="legal-links">
                    <li><a href="Confidentialité.php">Privacy Policy</a></li>
                    <li><a href="condition.php">Terms & Conditions</a></li>
                    <li><a href="mention_legal.php">Legal Notice</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupération des données du produit depuis PHP
            const productData = <?= json_encode([
                                    'currentProduct' => [
                                        'id' => $produit['idp'],
                                        'name' => $produit['nomp'],
                                        'mainImg' => $thumbnails[0],
                                        'thumbnails' => $thumbnails,
                                        'oldPrice' => !empty($produit['old_price_display']) ? '$' . number_format($produit['old_price_display'], 2) : '',
                                        'newPrice' => '$' . number_format($produit['prix'], 2),
                                        'description' => $produit['descp'],
                                        'category' => $produit['catégorie'],
                                        'sizes' => $tailles,
                                        'stock' => $produit['stock']
                                    ]
                                ]) ?>;

            // 1. Gestion de la galerie d'images
            const mainImg = document.getElementById("mainImg");
            const thumbs = document.querySelectorAll(".thumb");
            const prev = document.getElementById("prev");
            const next = document.getElementById("next");
            let currentIndex = 0;

            function updateMainImage(index) {
                thumbs.forEach(img => img.classList.remove("active"));
                mainImg.src = productData.currentProduct.thumbnails[index];
                thumbs[index].classList.add("active");
                currentIndex = index;
            }

            // Initialisation des miniatures
            productData.currentProduct.thumbnails.forEach((thumb, index) => {
                if (thumbs[index]) {
                    thumbs[index].src = thumb;
                    thumbs[index].addEventListener("click", () => updateMainImage(index));
                }
            });

            // Navigation
            prev.addEventListener("click", () => {
                if (currentIndex > 0) updateMainImage(currentIndex - 1);
            });

            next.addEventListener("click", () => {
                if (currentIndex < productData.currentProduct.thumbnails.length - 1) {
                    updateMainImage(currentIndex + 1);
                }
            });

            // 2. Gestion du panier avec base de données
            const panierForm = document.getElementById('panierForm');
            const quantityInput = document.querySelector('input[name="quantite"]');
            const sizeSelect = document.querySelector('select[name="taille"]');
            const cartCount = document.querySelector('.cart-count');
            const deliveryMessage = document.getElementById('livraison-message');
            const addToCartButton = document.getElementById('button1');

            // Validation de la quantité
            quantityInput.addEventListener('change', function() {
                if (this.value < 1) this.value = 1;
                if (this.value > productData.currentProduct.stock) {
                    this.value = productData.currentProduct.stock;
                    alert(`Quantité maximale disponible: ${productData.currentProduct.stock}`);
                }
            });
            // Gestion de l'ajout au panier
            panierForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);

                console.log("Données envoyées:", Object.fromEntries(formData));

                try {
                    const response = await fetch('api/ajouter.php', {
                        method: 'POST',
                        body: formData
                    });

                    console.log("Response object:", response);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const rawResponse = await response.text();
                    console.log("Réponse brute:", rawResponse);

                    const data = JSON.parse(rawResponse);

                    if (data.status === 'success') {
                        showAddedToCartFeedback();
                        alert("Succès : " + data.message);
                    } else {
                        alert("Erreur : " + data.message);
                    }
                } catch (error) {
                    console.error("Erreur complète:", error);
                    alert("Erreur réseau - Voir la console (F12)");
                }
            });

            // Fonctions utilitaires
            function showAddedToCartFeedback() {
                const originalText = addToCartButton.textContent;
                addToCartButton.textContent = '✓ Ajouté!';
                addToCartButton.style.backgroundColor = '#4CAF50';

                setTimeout(() => {
                    addToCartButton.textContent = originalText;
                    addToCartButton.style.backgroundColor = '#f8a932';
                }, 2000);
            }

            function updateCartCount() {
                fetch('get_cart_count.php')
                    .then(response => response.json())
                    .then(data => {
                        if (cartCount) {
                            cartCount.textContent = data.count;
                        }
                    });
            }

            function updateDeliveryMessage() {
                fetch('get_cart_total.php')
                    .then(response => response.json())
                    .then(data => {
                        if (deliveryMessage) {
                            if (data.total >= 189) {
                                deliveryMessage.textContent = 'Félicitations! Livraison gratuite!';
                            } else {
                                const remaining = (189 - data.total).toFixed(2);
                                deliveryMessage.textContent =
                                    `Ajoutez encore $${remaining} pour la livraison gratuite`;
                            }
                        }
                    });
            }

            // Initialisation au chargement
            updateCartCount();
            updateDeliveryMessage();
        });
    </script>
</body>
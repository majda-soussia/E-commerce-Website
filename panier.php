<?php
session_start();
$isConnected = isset($_SESSION['user_id']);
// Connexion base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Vérifier l'utilisateur connecté
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); // Redirigez vers la page de connexion
        exit();
    }
    $userId = $_SESSION['user_id'];

    // Vérifier si le panier existe
    $checkStmt = $conn->prepare("SELECT COUNT(*) as cart_count FROM panierr WHERE user_id = :user_id");
    $checkStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $checkStmt->execute();
    $cartExists = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($cartExists['cart_count'] > 0) {
        // Récupérer les articles du panier
        $stmt = $conn->prepare("
            SELECT 
                p.id as cart_item_id,
                p.quantite as quantity,
                p.taille as size,
                p.date_ajout,
                pr.idp as product_id,
                pr.nomp as product_name,
                pr.prix as product_price,
                pr.old_price,
                pr.image as product_image,
                pr.stock
            FROM panierr p
            JOIN produits pr ON p.produit_id = pr.idp
            WHERE p.user_id = :user_id
            ORDER BY p.date_ajout DESC
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calcul des totaux
        $subtotal = 0;
        $savings = 0;
        foreach ($items as $item) {
            $subtotal += $item['product_price'] * $item['quantity'];
            if (!empty($item['old_price']) && $item['old_price'] > 0) {
                $savings += ($item['old_price'] - $item['product_price']) * $item['quantity'];
            }
        }
        $total = $subtotal;
    } else {
        $items = [];
    }
    
} catch(PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Shopping Cart</title>
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

    mobile-menu-button.open .menu-icon:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }

    .mobile-menu-button.open .menu-icon:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-button.open .menu-icon:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
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

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }

    /* Categories Section */
    .category-card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease;
        min-height: 400px;
    }

    .category-card:hover {
        transform: translateY(-5px);
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .category-content {
        position: relative;
        z-index: 2;
        color: white;
        padding: 2rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        background: linear-gradient(transparent 20%, rgba(0, 0, 0, 0.7));
    }

    .category-cta {
        color: white;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1rem;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .category-cta:hover {
        transform: translateX(5px);
        color: var(--primary-color);
    }

    .sale-text {
        color: #ffd700;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    /* Main Content */
    .main-content {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-title {
        font-size: 2rem;
        margin-bottom: 2rem;
        color: var(--dark-color);
        text-align: center;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }

    .product-card {
        position: relative;
        background-color: #fff;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }

    .product-title {
        font-size: 1rem;
        margin: 0.75rem 1rem 0;
        font-weight: 500;
        color: var(--dark-color);
    }

    .product-price {
        margin: 0.5rem 1rem 1rem;
        font-weight: 600;
    }

    .current-price {
        color: var(--danger-color);
    }

    .old-price {
        text-decoration: line-through;
        color: var(--secondary-color);
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .wishlist-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.8);
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: var(--transition);
    }

    .product-card:hover .wishlist-button {
        opacity: 1;
    }

    .wishlist-button:hover {
        background: var(--danger-color);
        color: white;
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

    /* Responsive */
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
    }

    @media (max-width: 480px) {
        .footer-container {
            grid-template-columns: 1fr;
        }

        .footer-section:last-child {
            grid-column: span 1;
        }

        .legal-links {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    .social-links {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: var(--transition);
    }

    .social-links a:hover {
        background-color: var(--primary-color);
        transform: translateY(-3px);
    }

    .newsletter {
        margin-top: 1.5rem;
    }

    .newsletter h4 {
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }

    .newsletter-form {
        display: flex;
    }

    .newsletter-form input {
        flex: 1;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: var(--border-radius) 0 0 var(--border-radius);
    }

    .newsletter-form button {
        padding: 0.5rem 1rem;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
        cursor: pointer;
        transition: var(--transition);
    }

    .newsletter-form button:hover {
        background-color: #0069d9;
    }

    .footer-bottom {
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        font-size: 0.9rem;
        color: #aaa;
    }

    .legal-links {
        display: flex;
        justify-content: center;
        list-style: none;
        margin-top: 1rem;
        gap: 1.5rem;
    }

    .legal-links a {
        color: #aaa;
        text-decoration: none;
        transition: var(--transition);
    }

    .legal-links a:hover {
        color: white;
    }

    /* Section Catégories */
    .categories-section {
        padding: 2rem 1rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        text-align: center;
        font-size: 1.8rem;
        margin-bottom: 2rem;
        color: #333;
    }




    /* Responsive Styles */
    @media (max-width: 992px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }

    @media (max-width: 768px) {
        body {
            padding-top: 70px;
        }

        .mobile-menu-button {
            display: block;
        }



        .submenu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            display: none;
            padding-left: 1rem;
        }

        .submenu.active {
            display: block;
        }

        .search-form input {
            width: 100%;
        }

        .search-form input:focus {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .header {
            padding: 0.75rem 1rem;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .product-image {
            height: 200px;
        }

        .footer-container {
            grid-template-columns: 1fr;
        }

        .legal-links {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    .video-header {
        position: relative;
        width: 100%;
        height: 70vh;
        /* Ajustez la hauteur selon vos besoins */
        overflow: hidden;
    }

    #header-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
    }

    .cart-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .cart-item {
        display: flex;
        border-bottom: 1px solid #eee;
        padding: 15px 0;
        align-items: center;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 20px;
    }

    .product-info {
        flex: 1;
    }

    .product-title {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .product-price {
        color: #e74c3c;
        font-weight: bold;
    }

    .product-size {
        color: #7f8c8d;
        font-size: 0.9em;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }

    .quantity-btn {
        background: #f1f1f1;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1.1em;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        margin: 0 10px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .remove-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 20px;
    }

    .cart-summary {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .total {
        font-weight: bold;
        font-size: 1.2em;
        border-top: 1px solid #eee;
        padding-top: 10px;
        margin-top: 10px;
    }

    .checkout-btn {
        background: #2ecc71;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1.1em;
        width: 100%;
        margin-top: 20px;
    }

    .empty-cart {
        text-align: center;
        padding: 50px 0;
    }

    .continue-shopping {
        display: inline-block;
        margin-top: 20px;
        color: #3498db;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-image {
            margin-bottom: 15px;
        }

        .quantity-control {
            margin: 15px 0;
        }
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
    <br><br><br><br>
    <main>
        <div class="container py-5">
            <h1 class="mb-4">Your Shopping Cart</h1>

            <?php if (!empty($items)): ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php foreach ($items as $item): 
                                $inStock = $item['stock'] >= $item['quantity'];
                            ?>
                            <div class="row mb-3 align-items-center cart-item" data-id="<?= $item['cart_item_id'] ?>">
                                <div class="col-3 col-md-2">
                                    <img src="<?= htmlspecialchars($item['product_image'] ?? 'images/default-product.jpg') ?>" 
                                         alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                         class="img-fluid product-img">
                                </div>
                                <div class="col-9 col-md-6">
                                    <h5 class="mb-1"><?= htmlspecialchars($item['product_name']) ?></h5>
                                    
                                    <?php if (!empty($item['old_price']) && $item['old_price'] > 0): ?>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="original-price me-2"><?= number_format($item['old_price'], 2, ',', ' ') ?> €</span>
                                        <span class="discounted-price"><?= number_format($item['product_price'], 2, ',', ' ') ?> €</span>
                                        <span class="badge savings-badge ms-2">
                                            Économisez <?= number_format($item['old_price'] - $item['product_price'], 2, ',', ' ') ?> €
                                        </span>
                                    </div>
                                    <?php else: ?>
                                    <div class="discounted-price mb-1"><?= number_format($item['product_price'], 2, ',', ' ') ?> €</div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['size'])): ?>
                                    <div class="text-muted small mb-1">Taille: <?= htmlspecialchars($item['size']) ?></div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['color'])): ?>
                                    <div class="text-muted small mb-1">
                                        Couleur: 
                                        <span class="d-inline-block rounded-circle" style="width:15px;height:15px;background-color:<?= htmlspecialchars($item['color']) ?>"></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="small <?= !$inStock ? 'stock-low' : 'text-muted' ?>">
                                        <?= $inStock ? "En stock ({$item['stock']} disponible(s))" : "Stock faible ({$item['stock']} disponible(s))" ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mt-2 mt-md-0">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary quantity-btn minus" type="button">-</button>
                                        <input type="number" class="form-control quantity-input text-center" 
                                               value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>">
                                        <button class="btn btn-outline-secondary quantity-btn plus" type="button">+</button>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 text-end mt-2 mt-md-0">
                                    <div class="fw-bold"><?= number_format($item['product_price'] * $item['quantity'], 2, ',', ' ') ?> €</div>
                                    <button class="btn btn-link text-danger p-0 remove-btn">Supprimer</button>
                                </div>
                            </div>
                            <hr class="my-2">
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Récapitulatif</h5>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total:</span>
                                <span><?= number_format($subtotal, 2, ',', ' ') ?> €</span>
                            </div>
                            
                            <?php if ($savings > 0): ?>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Économies:</span>
                                <span>-<?= number_format($savings, 2, ',', ' ') ?> €</span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Livraison:</span>
                                <span>Gratuite</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                                <span>Total:</span>
                                <span><?= number_format($total, 2, ',', ' ') ?> €</span>
                            </div>
                            
                            <a href="myordre.php" class="btn btn-primary w-100">Passer la commande</a>
                            <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Continuer vos achats</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#ddd" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <h3 class="mb-3">Votre panier est vide</h3>
                <p class="mb-4">Commencez par ajouter quelques articles à votre panier</p>
                <a href="index.php" class="btn btn-primary">Parcourir les produits</a>
            </div>
        <?php endif; ?>
        </div>
    </main>


    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3 class="footer-heading">Help</h3>
                <ul class="footer-links">
                    <li><a href="mycompte.php" class="footer-link">Login</a></li>
                    <li><a href="créecompte.php" class="footer-link">Create an Account</a></li>
                    <li><a href="modepaiement.php" class="footer-link">My Cart</a></li>
                    <li><a href="favoris.php" class="footer-link">Favorites</a></li>
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
                    <a href="https://www.facebook.com/profile.php?id=100076255674035" class="social-link"
                        aria-label="Facebook" target="_blank" rel="noopener noreferrer">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quantity controls
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.quantity-input');
                    let value = parseInt(input.value);
                    const max = parseInt(input.max);

                    if (this.classList.contains('minus') && value > 1) {
                        input.value = value - 1;
                    } else if (this.classList.contains('plus') && value < max) {
                        input.value = value + 1;
                    }

                    updateCartItem(this.closest('.cart-item'));
                });
            });

            // Direct quantity input
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function () {
                    const max = parseInt(this.max);
                    if (this.value < 1) this.value = 1;
                    if (this.value > max) this.value = max;
                    updateCartItem(this.closest('.cart-item'));
                });
            });

            // Remove item
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const item = this.closest('.cart-item');
                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        removeCartItem(item);
                    }
                });
            });

           // Update cart item
           function updateCartItem(item) {
                const id = item.getAttribute('data-id');
                const quantity = item.querySelector('.quantity-input').value;

                fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&quantity=${quantity}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error updating cart: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating cart');
                    });
            }

            // Remove item from cart
            function removeCartItem(item) {
                const id = item.getAttribute('data-id');

                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (document.querySelectorAll('.cart-item').length === 1) {
                                location.reload();
                            } else {
                                item.remove();
                                location.reload(); // To update totals
                            }
                        } else {
                            alert('Error removing item: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing item');
                    });
            }
        });
    </script>


</body
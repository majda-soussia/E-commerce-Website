<?php
session_start(); // Start session if not already started

// Check if user is connected
$isConnected = isset($_SESSION['user_id']); // or your session variable for logged-in users
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>My Shop</title>
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
    <main><br>
        <!--<img src="imges/70.jpg" width="1500" /><br><br>-->
        <div class="video-header">
            <video id="header-video" autoplay muted loop playsinline>
                <source src="4407724-hd_1920_1080_30fps.mp4" type="video/mp4">
                Votre navigateur ne supporte pas les vidéos HTML5.
            </video>
        </div>
        <aside class="categories-section aside">
            <h2 class="section-title">Catégories</h2>

            <!-- Categories Section -->
            <section class="categories-section">
                <div class="section-header">
                    <h2 class="section-title">Explore Collections</h2>
                    <p class="section-subtitle">Discover our curated selection of fashion essentials</p>
                </div>

                <div class="categories-grid">
                    <!-- Women's Collection -->
                    <article class="category-card ">
                        <img src="imges/55.webp" alt="Women's fashion collection" class="category-image">
                        <div class="category-content">
                            <h3>Women's Fashion</h3>
                            <a href="#" class="category-cta">View Collection →</a>
                        </div>
                    </article>

                    <!-- Men's Collection -->
                    <article class="category-card ">
                        <img src="imges/19.jpg" alt="Men's fashion collection" class="category-image">
                        <div class="category-content">
                            <h3>Men's Fashion</h3>
                            <a href="#" class="category-cta">View Collection →</a>
                        </div>
                    </article>

                
                </div>
            </section>
        </aside>
        <div class="product-grid main-content">
            <article class="product-card">
                <a href="achete1.html?id=5" class="product-link">
                    <img src="imges/16.webp" alt="set " class="product-image">
                    <h3> Jupe plissée</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>

            <article class="product-card">
                <a href="#" class="product-link">
                    <img src="imges/2.webp" alt="set " class="product-image">
                    <h3> Set long_l</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="#" class="product-link">
                    <img src="imges/10.jpg" alt="set " class="product-image">
                    <h3> T_shirt</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.html?id=2" class="product-link">
                    <img src="imges/jupefemme/113.jpg" alt="set " class="product-image">
                    <h3> Jupe mi-longue avec poche cargo</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.html?id=35" class="product-link">
                    <img src="imges/t_shirtfemme/7.jpg"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt à manches courtes et col ras du cou à imprimé universitaire</h3>
                    <div class="product-price">$59.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.html?id=36" class="product-link">
                    <img src="imges/t_shirtfemme/8.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt de grossesse oversize à slogan Arizona</h3>
                    <div class="product-price">$59.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('header-video');

            // Force la lecture sur mobile
            function enforceVideoPlay() {
                if (video.paused) {
                    video.play().catch(e => {
                        console.log("Erreur de lecture:", e);
                        // Réessaye après 1 seconde
                        setTimeout(enforceVideoPlay, 1000);
                    });
                }
            }

            // Gestion de la boucle
            video.addEventListener('ended', function () {
                this.currentTime = 0;
                this.play();
            });

            // Vérification toutes les 3 secondes
            setInterval(enforceVideoPlay, 3000);

            // Démarrer la vidéo
            enforceVideoPlay();
        });
        // Newsletter Subscription
        document.querySelector('.newsletter-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();

            if (validateEmail(email)) {
                // Save email to localStorage
                const subscriptions = JSON.parse(localStorage.getItem('newsletterSubscriptions') || '[]');
                if (!subscriptions.includes(email)) {
                    subscriptions.push(email);
                    localStorage.setItem('newsletterSubscriptions', JSON.stringify(subscriptions));
                    alert('Merci pour votre abonnement !');
                    emailInput.value = '';
                } else {
                    alert('Cet email est déjà inscrit !');
                }
            } else {
                alert('Veuillez entrer une adresse email valide');
            }
        });

        // Social Media Interaction Tracking
        document.querySelectorAll('.social-link').forEach(link => {
            link.addEventListener('click', function (e) {
                const platform = this.querySelector('img').alt;
                console.log(`Social media link clicked: ${platform}`);
                // You can add analytics tracking here
            });
        });

        // Email Validation Helper
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Legal Links Analytics (optional)
        document.querySelectorAll('.legal-links a').forEach(link => {
            link.addEventListener('click', function (e) {
                console.log(`Legal link clicked: ${this.textContent}`);
            });
        });
    </script>


</body>
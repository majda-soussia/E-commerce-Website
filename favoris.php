<?php
session_start(); // Start session if not already started

// Check if user is connected
$isConnected = isset($_SESSION['user_id']); // or your session variable for logged-in users
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites </title>
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

        mobile-menu-button.open .menu-icon:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .mobile-menu-button.open .menu-icon:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-button.open .menu-icon:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
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

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }

        .warning {
            background: #ffe6e6;
            border-color: #ff4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .contact-info {
            background: #e8f4ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        ul {
            list-style-type: square;
            padding-left: 20px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }
        }

        /* Footer Styles */
        .footer,
        .footer-container {
            background-color: #2c3e50 !important;
            /* Ensure all sections have the same color */
            color: #ecf0f1;
            /* Ensure text remains visible */
        }

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

        /* Container styling (optional) */
        .contact-container {
            padding: 10px;
            /* matches your current dark tone */
            background-color: #ffffff;
            border-radius: 15px;
            color: #000000;

            margin: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Title */
        .contact-container h2 {
            font-size: 24px;
            color: #000000;
            margin-bottom: 15px;
            border-bottom: 2px solid #3889e6;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Paragraphs */
        .contact-container p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #060606;
        }

        /* Email link */
        .contact-container a {
            color: #3889e6;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .contact-container a:hover {
            color: #ffa07a;
        }

        /* Add to your existing styles */
        .favorites-header {
            text-align: center;
            margin: 2rem 0;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .empty-favorites {
            text-align: center;
            padding: 3rem;
            font-size: 1.2rem;
            color: #666;
        }

        .favorite-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .favorite-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .remove-favorite {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Favorites Layout */
        .favorites-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .favorites-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .favorites-header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }

        /* Favorite Item Card */
        .favorite-item {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .favorite-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image-link {
            display: block;
            height: 200px;
            overflow: hidden;
        }

        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }

        .favorite-item:hover .product-image {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.1rem;
            color: #000000;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .product-price {
            font-size: 1.2rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .product-category {
            display: inline-block;
            color: #000000;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .remove-favorite {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            color: #dc2626;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .remove-favorite:hover {
            background: #dc2626;
            color: white;
        }

        /* Empty State */
        .empty-favorites {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--light-gray);
            border-radius: 12px;
            margin: 2rem 0;
        }

        .empty-favorites h3 {
            font-size: 1.5rem;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        .empty-favorites p {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .browse-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .browse-btn:hover {
            background: #5b21b6;
            transform: translateY(-2px);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .favorites-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }

            .favorites-header h1 {
                font-size: 2rem;
            }
        }

        .wishlist-button {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            color: #ccc;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .wishlist-button:hover {
            color: #ff6b6b;
            transform: scale(1.1);
        }

        .wishlist-button.active {
            color: #ff4757;
            animation: pulse 0.5s;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Beautiful category styling */
        .product-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Specific category colors */
        .product-category[data-category="t_shirtfemme"] {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        }

        .product-category[data-category="robe"] {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }

        .product-category[data-category="pantalon"] {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .product-category[data-category="pantalonfemme"] {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .product-category[data-category="robefemme"] {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }
    </style>
</head>

<body>
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
    <br><br>
    <br><br>
    <main class="container">
        <div class="favorites-header">
            <h1><?php echo $isConnected ? 'Your Favorite Items' : 'My Favorite Items'; ?></h1>
            <p><?php echo $isConnected ? 'Browse your saved items' : 'Sign in to save favorites across devices'; ?></p>
        </div>

        <div class="product-grid" id="favorites-container">
            <!-- Favorites will be loaded here -->
        </div>

        <?php if (!$isConnected): ?>
            <div class="guest-notice">
                <p>You're currently browsing as a guest. <a href="mycompte.php">Sign in</a> to save your favorites
                    permanently.</p>
            </div>
        <?php endif; ?>
    </main>




    <!---partie l5ra fi page fix  -->
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
        document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('favorites-container');
        const favorites = JSON.parse(localStorage.getItem('favorites')) || [];

        if (favorites.length === 0) {
            container.innerHTML = `
                <div class="empty-favorites">
                    <h3>Votre liste de favoris est vide</h3>
                    <p>Cliquez sur le cœur ♥ des produits pour les ajouter ici</p>
                    <a href="t_shirtfemme.php" class="browse-btn">Parcourir les produits</a>
                </div>
            `;
            return;
        }

        container.innerHTML = favorites.map(product => `
            <article class="favorite-item">
                <a href="achete1.php?id=${product.id}" class="product-image-link">
                    <img src="${product.image}" alt="${product.title}" class="product-image">
                </a>
                <div class="product-info">
                    <h3 class="product-title">${product.title}</h3>
                    <div class="product-price">${product.price}</div>
                    <span class="product-category">${product.category.replace('_', ' ')}</span>
                </div>
                <button class="remove-favorite" 
                        onclick="removeFavorite('${product.id}', '${product.category}')"
                        aria-label="Retirer des favoris">×</button>
            </article>
        `).join('');
        // Add click event to entire product card (excluding the remove button)
    document.querySelectorAll('.favorite-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Don't redirect if clicking the remove button
            if (e.target.classList.contains('remove-favorite') || 
                e.target.closest('.remove-favorite')) {
                return;
            }
            
            // Get the product link and navigate to it
            const link = this.querySelector('a').href;
            window.location.href = link;
        });
    });
    });

    function removeFavorite(productId, productCategory) {
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        favorites = favorites.filter(item => 
            !(item.id === productId && item.category === productCategory)
        );
        localStorage.setItem('favorites', JSON.stringify(favorites));
        location.reload();
    }

    // Update heart buttons on product pages
    function updateHeartButtons() {
        const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        document.querySelectorAll('.wishlist-button').forEach(button => {
            const productCard = button.closest('.product-card');
            const productId = productCard.querySelector('a').getAttribute('href').split('id=')[1];
            const productCategory = window.location.pathname
                .split('/')
                .pop()
                .replace('.php', '')
                .replace('.html', '');

            const isFavorite = favorites.some(item => 
                item.id === productId && item.category === productCategory
            );

            button.classList.toggle('active', isFavorite);
            button.setAttribute('aria-label', isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris');
        });
    }
    </script>
</body>

</html>
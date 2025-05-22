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
    <title>Phone </title>
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
        mobile-menu-button.open .menu-icon:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.mobile-menu-button.open .menu-icon:nth-child(2) {
    opacity: 0;
}

.mobile-menu-button.open .menu-icon:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
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
        .phone-contact {
            background-color: #ffffff;
            /* dark background like your current style */
            color: #020202;
            padding: 30px;
            border-radius: 15px;
            margin: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Title */
        .phone-contact h2 {
            font-size: 24px;
            color: #070606;
            margin-bottom: 15px;
            border-bottom: 2px solid #3889e6;
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Paragraphs */
        .phone-contact p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #0e0e0e;
        }

        /* Bold text inside paragraphs */
        .phone-contact strong {
            color: #131212;
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
    <aside>
        <div class="phone-contact">
            <h2>Call Us</h2>
            <p>Need help right away? You can reach our customer care team by phone.</p>
            <p><strong>Phone Number:</strong> +(216) 53 640 191</p>
            <p><strong>Hours:</strong> Monday to Friday, 9 AM – 6 PM (Local Time)</p>
            <p>We're happy to assist you with orders, returns, product info, or any questions.</p>
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
                    <a href="#" class="social-link" aria-label="Facebook">
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
                    <li><a href="C:\Users\User\Desktop\projet web\Confidentialité.php">Privacy Policy</a></li>
                    <li><a href="condition.php">Terms & Conditions</a></li>
                    <li><a href="C:\Users\User\Desktop\projet web\mention_legal.php">Legal Notice</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
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

</html>
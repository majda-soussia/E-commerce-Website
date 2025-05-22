<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige vers la page de connexion
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$sql = "SELECT nom, prenom FROM utilisateur WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $nom = $user['nom'];
    $prenom = $user['prenom'];
} else {
    $nom = $prenom = '';
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            /*--dark-color: #343a40;*/
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

        /*main*/

        .account-dashboard {
            display: flex;
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        .sidebar {
            width: 300px;
            background-color: #ffffff;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            padding: 2rem 1.5rem;
            box-shadow: var(--box-shadow);
        }

        .user-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);

        }

        .welcome-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1.5rem;
            border: 3px solid var(--primary-color);
            padding: 3px;
            box-shadow: var(--box-shadow);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.25rem;
            color: var(--secondary-color);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            margin: 0.25rem 0;
        }

        .menu-item:hover {
            background-color: rgba(0, 123, 255, 0.05);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .menu-item.logout:hover {
            color: var(--danger-color);
            background-color: rgba(220, 53, 69, 0.05);
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            filter: grayscale(100%);
            transition: var(--transition);
        }

        .menu-item:hover .menu-icon {
            filter: grayscale(0);
        }

        .content-area {
            flex: 1;
            padding: 3rem 2.5rem;
            background-color: #ffffff;
            border-radius: var(--border-radius);
            margin: 1rem;
            box-shadow: var(--box-shadow);
        }

        /* Active state styling */
        .menu-item.active {
            background-color: var(--primary-color);
            color: white !important;
        }

        .menu-item.active .menu-icon {
            filter: brightness(0) invert(1);
        }

        /* Success state for positive actions */
        .menu-item.success {
            color: var(--success-color);
        }

        .password-change-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .password-change-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .security-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }

        .password-change-header h1 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .password-change-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .required {
            color: #e74c3c;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding-right: 2.5rem;
        }

        .form-group input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            color: #7f8c8d;
            cursor: pointer;
        }

        .password-requirements {
            margin-top: 0.5rem;
            background: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .password-requirements p {
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
        }

        .password-requirements ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .requirement {
            color: #7f8c8d;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .requirement i {
            font-size: 0.9rem;
        }

        .submit-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.85rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .submit-btn i {
            font-size: 1rem;
        }

        /* Pour les icônes Font Awesome */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
        requirement.met {
    color: #27ae60;
}

.requirement.met i {
    color: inherit;
}

.invalid {
    border-color: #e74c3c !important;
    box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2) !important;
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
                        <li><a href="#" class="submenu-link">Pants</a></li>
                        <li><a href="#" class="submenu-link">Dresses</a></li>
                        <li><a href="jupefemme1.php" class="submenu-link">Skirts</a></li>
                        <li><a href="#" class="submenu-link">Coats</a></li>

                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <button class="nav-link submenu-toggle">Men</button>
                    <ul class="submenu">
                        <li><a href="#" class="submenu-link">T-shirts</a></li>
                        <li><a href="#" class="submenu-link">Shirts</a></li>
                        <li><a href="#" class="submenu-link">Pants</a></li>
                        <li><a href="#" class="submenu-link">Suits</a></li>
                        <li><a href="#" class="submenu-link">Coats</a></li>
                        <li><a href="#" class="submenu-link">Jackets</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#" class="nav-link">Sale</a></li>

                <li class="nav-item search-item">
                    <form role="search" class="search-form">
                        <input type="search" placeholder="Search products..." aria-label="Search products">
                        <button type="submit" aria-label="Search">
                            <img src="imges/recher.png" alt="" width="25" height="15">
                        </button>
                    </form>
                </li>

                <li class="nav-item icon-item">
                    <a href="#" class="nav-icon" aria-label="Wishlist">
                        <img src="imges/heart.png" alt="Wishlist" width="25" height="15">
                    </a>
                </li>

                <li class="nav-item icon-item">
                    <a href="#" class="nav-icon" aria-label="Shopping cart">
                        <img src="imges/panier.png" alt="Cart" width="25" height="15">
                        <span class="cart-count">0</span>
                    </a>
                </li>

                <li class="nav-item icon-item">
                    <a href="C:\Users\User\Desktop\projet web\mycompte.html" class="nav-icon" aria-label="My account">
                        <img src="imges/compte.png" alt="Account" width="25" height="15">
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <br><br>
    <br><br><br>
    <main class="account-dashboard">
        <div class="sidebar">
            <section class="user-profile">
                <img src="imges\bienv.png" alt="Welcome" class="welcome-icon">
                <div class="user-greeting">
                    <p class="greeting">Hello, <h1><?= htmlspecialchars($nom . ' ' . $prenom) ?></h1></p>
                    
                </div>
            </section>

            <nav class="account-menu">
                <div class="menu-section">
                    <a href="#" class="menu-item">
                        <img src="imges/commande.png" alt="Orders" class="menu-icon">
                        <span class="menu-label">My Orders</span>
                    </a>
                </div>

                <div class="menu-section">
                    <a href="mesinfo.php" class="menu-item">
                        <img src="imges/inforrmation.png" alt="Information" class="menu-icon">
                        <span class="menu-label">Account Information</span>
                    </a>
                    <a href="changemotpass.php" class="menu-item">
                        <img src="imges/securite.png" alt="Security" class="menu-icon">
                        <span class="menu-label">Change Password</span>
                    </a>
                    <a href="modepaiement.php" class="menu-item">
                        <img src="imges/paiement.png" alt="Payments" class="menu-icon">
                        <span class="menu-label">Payment Methods</span>
                    </a>
                </div>

                <div class="menu-section">
                    <a href="logout.php" class="menu-item logout">
                        <img src="imges/deconnexion.png" alt="Logout" class="menu-icon">
                        <span class="menu-label">Sign Out</span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="password-change-container">
            <div class="password-change-header">
                <img src="imges/securite.png" alt="Security Icon" class="security-icon">
                <h1>Change Your Password</h1>
                <p class="subtitle">Keep your account secure by updating your password regularly</p>
            </div>

            <form class="password-change-form">
                <div class="form-group">
                    <label for="current-password">Current Password <span class="required">*</span></label>
                    <input type="password" id="current-password" name="current-password" required
                        placeholder="Enter your current password">
                    <i class="fas fa-eye toggle-password"></i>
                </div>

                <div class="form-group">
                    <label for="new-password">New Password <span class="required">*</span></label>
                    <input type="password" id="new-password" name="new-password" required
                        placeholder="Create a new password">
                    <i class="fas fa-eye toggle-password"></i>
                    <div class="password-requirements">
                        <p>Password must contain:</p>
                        <ul>
                            <li class="requirement"><i class="fas fa-check-circle"></i> At least 10 characters</li>
                            <li class="requirement"><i class="fas fa-check-circle"></i> 1 uppercase letter</li>
                            <li class="requirement"><i class="fas fa-check-circle"></i> 1 number</li>
                            <li class="requirement"><i class="fas fa-check-circle"></i> 1 special character</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm New Password <span class="required">*</span></label>
                    <input type="password" id="confirm-password" name="confirm-password" required
                        placeholder="Re-enter your new password">
                    <i class="fas fa-eye toggle-password"></i>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-lock"></i> Update Password
                </button>
            </form>
        </div>
    </main><br>
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
    const form = document.querySelector('.password-change-form');
    const currentPassword = document.getElementById('current-password');
    const newPassword = document.getElementById('new-password');
    const confirmPassword = document.getElementById('confirm-password');
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    
    // Password requirements elements
    const requirements = {
        length: document.querySelectorAll('.requirement')[0],
        uppercase: document.querySelectorAll('.requirement')[1],
        number: document.querySelectorAll('.requirement')[2],
        special: document.querySelectorAll('.requirement')[3]
    };

    // Regular expressions for validation
    const minLength = /.{10,}/;
    const hasUpper = /[A-Z]/;
    const hasNumber = /\d/;
    const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

    // Toggle password visibility
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = button.previousElementSibling;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            button.classList.toggle('fa-eye-slash', !isPassword);
            button.classList.toggle('fa-eye', isPassword);
        });
    });

    // Real-time password validation
    newPassword.addEventListener('input', validateNewPassword);
    confirmPassword.addEventListener('input', validateConfirmPassword);

    function validateNewPassword() {
        const password = newPassword.value;
        
        // Test against requirements
        const isLengthValid = minLength.test(password);
        const isUpperValid = hasUpper.test(password);
        const isNumberValid = hasNumber.test(password);
        const isSpecialValid = hasSpecial.test(password);

        // Update requirement indicators
        requirements.length.classList.toggle('met', isLengthValid);
        requirements.uppercase.classList.toggle('met', isUpperValid);
        requirements.number.classList.toggle('met', isNumberValid);
        requirements.special.classList.toggle('met', isSpecialValid);

        return isLengthValid && isUpperValid && isNumberValid && isSpecialValid;
    }

    function validateConfirmPassword() {
        const isValid = confirmPassword.value === newPassword.value;
        confirmPassword.classList.toggle('invalid', !isValid && confirmPassword.value.length > 0);
        return isValid;
    }

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Validate current password
        if (currentPassword.value.trim() === '') {
            currentPassword.classList.add('invalid');
            isValid = false;
        } else {
            currentPassword.classList.remove('invalid');
        }

        // Validate new password
        const isNewValid = validateNewPassword();
        if (!isNewValid) {
            newPassword.classList.add('invalid');
            isValid = false;
        } else {
            newPassword.classList.remove('invalid');
        }

        // Validate confirm password
        const isConfirmValid = validateConfirmPassword();
        if (!isConfirmValid) {
            confirmPassword.classList.add('invalid');
            isValid = false;
        } else {
            confirmPassword.classList.remove('invalid');
        }

        if (isValid) {
            // Simulate form submission
            alert('Password changed successfully!');
            form.reset();
            
            // Reset validation states
            currentPassword.classList.remove('invalid');
            newPassword.classList.remove('invalid');
            confirmPassword.classList.remove('invalid');
            Object.values(requirements).forEach(req => req.classList.remove('met'));
        }
    });
});
// Newsletter Subscription
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
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
    link.addEventListener('click', function(e) {
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
    link.addEventListener('click', function(e) {
        console.log(`Legal link clicked: ${this.textContent}`);
    });
});
    </script>
</body>

</html>
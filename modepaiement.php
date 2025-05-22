<?php
session_start();

// Connexion base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier l'utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: mycompte.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Partie pour traiter l'AJAX si POST reçu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode_paiement'])) {
    $modePaiement = trim($_POST['mode_paiement']);

    $stmt = $conn->prepare("UPDATE utilisateur SET mode_paiement = ? WHERE id = ?");
    $stmt->bind_param("si", $modePaiement, $userId);

    if ($stmt->execute()) {
        echo 'Mode de paiement enregistré avec succès';
    } else {
        echo 'Erreur lors de l\'enregistrement du mode de paiement.';
    }
    $conn->close();
    exit(); // IMPORTANT : arrêter le script ici après réponse AJAX
}


// Récupérer infos utilisateur
$sql = "SELECT nom, prenom FROM utilisateur WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $nom = $user['nom'];
    $prenom = $user['prenom'];
} else {
    $nom = '';
    $prenom = '';
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditions Générales - ZEN.COM.TN</title>
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

        mobile-menu-button.open .menu-icon:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .mobile-menu-button.open .menu-icon:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-button.open .menu-icon:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
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

        /*
        .carte{
            border-style: groove;
            display: flex;
            justify-content: space-around;
        }
        .pay{ 
            justify-items: center;
            margin-left: 150px;
            margin-right: 150px ;
            background-color: #ffffff;
            border-radius: 15px ;
            border-bottom: 300px ;
        }*/
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }



        .payment-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }

        .payment-table th,
        .payment-table td {
            padding: 1.25rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .payment-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .payment-table tr:last-child td {
            border-bottom: none;
        }

        .payment-table tr:hover {
            background-color: #f8fafc;
        }

        .method-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .method-icon {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .badge {
            background: #e2e8f0;
            color: var(--text-dark);
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
        }

        .pay-btn {
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pay-btn:hover {
            opacity: 0.9;
        }

        #confirmation {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: white;
            padding: 1.25rem 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--success-color);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        #confirmation.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {

            .payment-table,
            .payment-table thead,
            .payment-table tbody,
            .payment-table th,
            .payment-table td,
            .payment-table tr {
                display: block;
            }

            .payment-table td {
                position: relative;
                padding-left: 45%;
            }

            .payment-table td::before {
                position: absolute;
                left: 1rem;
                width: 40%;
                padding-right: 1rem;
                content: attr(data-label);
                font-weight: 600;
                color: var(--primary-color);
            }
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
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <button class="nav-link submenu-toggle">Men</button>
                    <ul class="submenu">
                        <li><a href="#" class="submenu-link">T-shirts</a></li>
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
                    <a href="favoris.php" class="nav-icon" aria-label="Wishlist">
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
                    <p>Hello,
                    <h1><?php echo htmlspecialchars($prenom . ' ' . $nom); ?></h1>
                    </p>
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
                    <a href="changemotpass.php" class="menu-item"> <!-- Correction du chemin relatif -->
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
        <div class="container">
            <h1>Select Payment Method</h1>

            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Payment Method</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Payment Method">
                            <div class="method-info">
                                <img src="https://img.icons8.com/color/48/000000/visa.png" class="method-icon"
                                    alt="Credit Card">
                                <span>Credit Card</span>
                            </div>
                        </td>
                        <td data-label="Details">
                            <div class="badges">
                                <span class="badge">Visa</span>
                                <span class="badge">Mastercard</span>
                                <span class="badge">Amex</span>
                            </div>
                        </td>
                        <td data-label="Action">
                            <button class="pay-btn" onclick="selectPayment('Credit Card')">
                                Select & Pay
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Payment Method">
                            <div class="method-info">
                                <img src="https://img.icons8.com/color/48/000000/paypal.png" class="method-icon"
                                    alt="PayPal">
                                <span>PayPal</span>
                            </div>
                        </td>
                        <td data-label="Details">
                            <div class="badges">
                                <span class="badge">Buyer Protection</span>
                                <span class="badge">1-Click Pay</span>
                            </div>
                        </td>
                        <td data-label="Action">
                            <button class="pay-btn" onclick="selectPayment('PayPal')">
                                Select & Pay
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td data-label="Payment Method">
                            <div class="method-info">
                                <img src="https://img.icons8.com/ios-filled/50/000000/bank.png" class="method-icon"
                                    alt="Bank Transfer">
                                <span>Bank Transfer</span>
                            </div>
                        </td>
                        <td data-label="Details">
                            <div class="badges">
                                <span class="badge">SEPA</span>
                                <span class="badge">Instant Transfer</span>
                            </div>
                        </td>
                        <td data-label="Action">
                            <button class="pay-btn" onclick="selectPayment('Bank Transfer')">
                                Select & Pay
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="confirmation">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span class="confirmation-text"></span>
            </div>
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
        function selectPayment(method) {
            const confirmation = document.getElementById('confirmation');
            const textElement = confirmation.querySelector('.confirmation-text');

            // 1. Affiche un message visuel
            textElement.textContent = `Selected: ${method} - Redirecting to payment...`;
            confirmation.classList.add('show');

            // 2. Envoie vers le serveur pour enregistrer
            fetch(window.location.href, { // même fichier PHP
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'mode_paiement=' + encodeURIComponent(method) + '&ajax=1' // + ajouter ajax=1
            })
                .then(response => response.text())
                .then(data => {
                    document.querySelector('.confirmation-text').innerText = data;
                    console.log('Réponse du serveur:', data); // Ajoute ça pour voir la réponse
                })
                .catch(error => {
                    console.error('Erreur fetch:', error); // Voir erreurs
                    document.querySelector('.confirmation-text').innerText = 'Erreur lors de l\'enregistrement';
                });
            // 3. Cache le message après 3 secondes
            setTimeout(() => {
                confirmation.classList.remove('show');
            }, 3000);
        }


        // Keyboard accessibility
        document.querySelectorAll('.pay-btn').forEach(button => {
            button.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.target.click();
                }
            });
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

</html>
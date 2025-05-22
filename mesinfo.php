<?php
session_start();
//echo 'User ID: ' . ($_SESSION['user_id'] ?? 'Non défini') . '<br>';

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*new ajouter debut*/
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    // L'utilisateur n'est pas connecté ou l'ID n'est pas défini
    echo "<script>alert('❗ Vous devez être connecté pour accéder à cette page.'); window.location.href='login.php';</script>";
    exit();
} 
/*fin ajouter*/
// TRAITEMENT DU FORMULAIRE (si submit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sécuriser les entrées
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $email = $conn->real_escape_string($_POST['adresse']);
    $sexe = $conn->real_escape_string($_POST['genre']);
    $datenaissance = $conn->real_escape_string($_POST['date']);

    // Mise à jour dans la base de données
    $update = "UPDATE utilisateur 
               SET nom = ?, prenom = ?, telephone = ?, email = ?, sexe = ?, datenaissance = ? 
               WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssssi", $nom, $prenom, $telephone, $email, $sexe, $datenaissance, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Informations mises à jour avec succès !'); window.location.href='mesinfo.php';</script>";
        exit();
    } else {
        echo "<script>alert('❌ Erreur lors de la mise à jour.');</script>";
    }
    $stmt->close();
}

// Récupérer les informations pour afficher dans le formulaire
$sql = "SELECT nom, prenom, telephone, email, sexe, datenaissance FROM utilisateur WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
//echo '<pre>';
//print_r($user);
//echo '</pre>';
if ($user) {
    $nom = $user['nom'];
    $prenom = $user['prenom'];
    $telephone = $user['telephone'];
    $email = $user['email'];
    $sexe = $user['sexe'];
    $datenaissance = $user['datenaissance'];
} else {
   $nom = $prenom = $telephone = $email = $sexe = $datenaissance = '';
}

$stmt->close();
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

        mobile-menu-button.open .menu-icon:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .mobile-menu-button.open .menu-icon:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-button.open .menu-icon:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .content-area {
            display: flex;
    flex-direction: column;
            flex: 1;
            padding: 3rem 2.5rem;
            background-color: #ffffff;
            border-radius: var(--border-radius);
            margin: 1rem;
            box-shadow: var(--box-shadow);
            display: flex;
            justify-content: center;
            padding: 2rem;
            min-height: calc(100vh - 300px);

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

        .content-area h3 {
            color: #007bff;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .form-group input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.25);
        }

        .gender-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .gender-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .submit-btn {
            padding: 0.75rem;
            background-color: var(--dark-color);
            color: rgb(6, 114, 164);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #1b61a8;
            color: #fffdfd;
        }
    </style>
</head>

<body>
    <header class="header">
        <a class="logo" href="index.php">
            <h1>NameWebPage</h1>
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
                        <li><a href="#" class="submenu-link">Sportswear</a></li>
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
                    <a href="mycompte.php" class="nav-icon" aria-label="My account">
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
                    <p class="greeting">Hello, <h1><?= htmlspecialchars($nom . ' ' . $prenom) ?></h1> </p>
                </div>
            </section>

            <nav class="account-menu">
                <div class="menu-section">
                    <a href="#" class="menu-item">
                        <img src="imges/commande.png" alt="Orders" class="menu-icon">
                        <span class="menu-label">My Orders</span>
                    </a>
                    <a href="#" class="menu-item">
                        <img src="imges/retour.png" alt="Returns" class="menu-icon">
                        <span class="menu-label">My Returns</span>
                    </a>
                </div>

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

                <div class="menu-section">
                    <a href="logout.php" class="menu-item logout">
                        <img src="imges/deconnexion.png" alt="Logout" class="menu-icon">
                        <span class="menu-label">Sign Out</span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="content-area">
            <h3>This allows you to modify the basic data of your account</h3>
            <form method="POST" action="mesinfo.php">
                <div class="login-form">
                    <div class="form-group">
                        <label for="nom">Name :</label>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Surname :</label>
                        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Phone :</label>
                        <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($telephone) ?>"
                            pattern="[0-9]{8}" required>
                    </div>

                    <div class="form-group">
                        <label for="adresse">Email address :</label>
                        <input type="email" id="adresse" name="adresse" value="<?= htmlspecialchars($email) ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Gender :</label>
                        <div class="gender-group">
                            <label class="gender-option">
                                <input type="radio" name="genre" value="Femme" <?= ($sexe === 'Femme') ? 'checked' : '' ?>
                                    required>
                                Woman
                            </label>
                            <label class="gender-option">
                                <input type="radio" name="genre" value="Homme" <?= ($sexe === 'Homme') ? 'checked' : '' ?>
                                    required>
                                Man
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Birth date :</label>
                        <input type="date" name="date" value="<?= htmlspecialchars($datenaissance) ?>" min="1950-01-01"
                            max="2025-01-01" required>
                    </div>

                    <button type="submit" class="submit-btn">Save</button>
                </div>
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
</body>
<script>

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');

        // Create a div to show the final success message
        const successMessage = document.createElement('div');
        successMessage.style.marginTop = '1rem';
        successMessage.style.color = 'green';
        form.appendChild(successMessage);

        // Function to clear previous error messages
        function clearErrors() {
            const errors = form.querySelectorAll('.error-message');
            errors.forEach(error => error.remove());
            successMessage.textContent = '';
        }

        // Function to show error below a field
        function showError(input, message) {
            const error = document.createElement('div');
            error.classList.add('error-message');
            error.style.color = 'red';
            error.style.fontSize = '0.9rem';
            error.textContent = message;
            input.parentNode.appendChild(error);
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            clearErrors();

            // Grab form values
            const nom = document.getElementById('nom');
            const prenom = document.getElementById('prenom');
            const telephone = document.getElementById('telephone');
            const adresse = document.getElementById('adresse');
            const genre = document.querySelector('input[name="genre"]:checked');
            const date = document.querySelector('input[name="date"]');

            let hasError = false;

            // Check each field
            if (!nom.value.trim()) {
                showError(nom, "Please enter your name.");
                hasError = true;
            }
            if (!prenom.value.trim()) {
                showError(prenom, "Please enter your surname.");
                hasError = true;
            }
            if (!telephone.value.trim()) {
                showError(telephone, "Please enter your phone number.");
                hasError = true;
            } else if (!/^\d{8}$/.test(telephone.value.trim())) {
                showError(telephone, "Phone number must be 8 digits.");
                hasError = true;
            }
            if (!adresse.value.trim()) {
                showError(adresse, "Please enter your email address.");
                hasError = true;
            }
            if (!genre) {
                const genderGroup = document.querySelector('.gender-group');
                showError(genderGroup, "Please select your gender.");
                hasError = true;
            }
            if (!date.value) {
                showError(date, "Please select your birth date.");
                hasError = true;
            }

            // Show success if no errors
            if (!hasError) {
                successMessage.textContent = "✅ Your new information has been saved successfully!";
                form.reset(); // optional: reset the form after submission
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

    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function (e) {
            const platform = this.querySelector('img').alt;
            console.log(`Social media link clicked: ${platform}`);

        });
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    document.querySelectorAll('.legal-links a').forEach(link => {
        link.addEventListener('click', function (e) {
            console.log(`Legal link clicked: ${this.textContent}`);
        });
    });


</script>

</html>
<? 
// Après vérification réussie du mot de passe
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role']; // Stocker le rôle dans la session
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mycompte.css">
    <form action="mycomptephp.php" method="POST" ></form>
    <title>Connexion - NameWebPage</title>
</head>

<body>

    <!-- Header Section -->
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

    <!-- Main Content -->
    <form class="account-container" action="mycomptephp.php" method="POST" >
        <div class="account-form">
            <h2>CONNEXION</h2>
            
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="error">Email ou mot de passe incorrect</div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="pass" required>
            </div>
            
            <div class="form-options">
                <a href="oubliermotpass.php" class="forgot-password">Mot de passe oublié ?</a>
            </div>
            
            <button type="submit" class="submit-btn">Se connecter</button>
            
            <div class="account-switch">
                <p>Nouveau client ? <a href="créecompte.php">Créer un compte</a></p>
            </div>
        </div>
    </form>
    <!-- Footer identique à votre page précédente -->
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
                <p class="copyright">&copy; 2025 NameWebPage. All rights reserved.</p>
                <ul class="legal-links">
                    <li><a href="Confidentialité.php">Privacy Policy</a></li>
                    <li><a href="condition.php">Terms & Conditions</a></li>
                    <li><a href="mention_legal.php">Legal Notice</a></li>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Sélection des éléments
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const nav = document.querySelector('.nav');
            const submenuToggles = document.querySelectorAll('.submenu-toggle');

            // Gestion du menu mobile
            mobileMenuButton.addEventListener('click', function () {
                nav.classList.toggle('active');
                this.classList.toggle('open');
            });

            // Gestion des sous-menus
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    const parentItem = this.parentElement;

                    // Fermer les autres sous-menus ouverts
                    document.querySelectorAll('.submenu').forEach(menu => {
                        if (menu !== submenu && menu.classList.contains('active')) {
                            menu.classList.remove('active');
                            menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                        }
                    });

                    // Basculer l'état du sous-menu actuel
                    submenu.classList.toggle('active');
                    const isExpanded = submenu.classList.contains('active');
                    this.setAttribute('aria-expanded', isExpanded);

                    // Fermer si on clique à nouveau sur le même toggle
                    if (!isExpanded) {
                        parentItem.classList.remove('open');
                    } else {
                        parentItem.classList.add('open');
                    }
                });
            });

            // Fermer les menus quand on clique à l'extérieur
            document.addEventListener('click', function (e) {
                if (!nav.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                    nav.classList.remove('active');
                    mobileMenuButton.classList.remove('open');

                    document.querySelectorAll('.submenu').forEach(menu => {
                        menu.classList.remove('active');
                        menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        });
    </script>
</body>

</html>
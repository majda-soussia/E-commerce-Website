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
    <link rel="stylesheet" href="jupefemme.css" />
    <title>Jupe Femme</title>
</head>

<body>
    <!---header fixe fi koul page -->
    <!-- Header Section -->
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
    <br><br>

    <main class="main-content">
        <h2 class="page-title">Women's T-Shirts</h2>

        <div class="product-grid" id="favorites-container">
            <!-- Product 1 -->
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=1" class="product-link">
                    <img src="imges/t_shirtfemme/1.jpg" alt="T-shirt côtelé fantaisie rouge" class="product-image">
                    <h3 class="product-title">T-shirt côtelé fantaisie rouge</h3>
                    <div class="product-price">$50.99</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="1">♥</button>
            </article>

            <!-- Product 2 -->
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=2" class="product-link">
                    <img src="imges/t_shirtfemme/2.jpg" alt="T-shirt cropped manches courtes BEIGE"class="product-image">
                    <h3 class="product-title">T-shirt cropped manches courtes BEIGE</h3>
                    <div class="product-price">
                        <span class="old-price">$35.35</span>
                        <span class="current-price">$28.30</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="2">♥</button>
            </article>



            <!-- Product 4 -->
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=3" class="product-link">
                    <img src="imges/t_shirtfemme/4.jpg" alt="T-shirt rayé large à manches courtes BLEU"
                        class="product-image">
                    <h3 class="product-title">T-shirt rayé large à manches courtes BLEU</h3>
                    <div class="product-price">$20.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="3">♥</button>
            </article>

            <!-- Product 5 -->
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=4" class="product-link">
                    <img src="imges/t_shirtfemme/5.jpg" alt="T-shirt en jersey manches courtes imprimé BLANC"
                        class="product-image">
                    <h3 class="product-title">T-shirt en jersey manches courtes imprimé BLANC</h3>
                    <div class="product-price">$30.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="4">♥</button>
            </article>

            <!-- Product 7 -->
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=5" class="product-link">
                    <img src="imges/t_shirtfemme/7.jpg"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt à manches courtes et col ras du cou à imprimé universitaire</h3>
                    <div class="product-price">$40.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="5">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=6" class="product-link">
                    <img src="imges/t_shirtfemme/8.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt de grossesse oversize à slogan Arizona</h3>
                    <div class="product-price">$49.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="6">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=77" class="product-link">
                    <img src="imges/t_shirtfemme/9.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt oversize à slogan Im</h3>
                    <div class="product-price">$39.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="77">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=88" class="product-link">
                    <img src="imges/t_shirtfemme/10.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt oversize basique à rayures</h3>
                    <div class="product-price">$59.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="88">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=99" class="product-link">
                    <img src="imges/t_shirtfemme/11.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">T-shirt oversize en coton à imprimé cerise</h3>
                    <div class="product-price">$59.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="99">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=100" class="product-link">
                    <img src="imges/t_shirtfemme/12.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title"> T-shirt de grossesse oversize à slogan Dsgn Studio</h3>
                    <div class="product-price">$39.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="100">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=111" class="product-link">
                    <img src="imges/t_shirtfemme/13.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">SHORT SLEEVE - Polo - brown</h3>
                    <div class="product-price">$49.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="111">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=122" class="product-link">
                    <img src="imges/t_shirtfemme/14.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">REGULAR FIT POLO CROCHET - Polo - green glow</h3>
                    <div class="product-price">$69.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="122">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=133" class="product-link">
                    <img src="imges/t_shirtfemme/15.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">BYMMMORLA - Pullover - humus melange</h3>
                    <div class="product-price">$39.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="133">♥</button>
            </article>
            <article class="product-card" data-category="t_shirtfemme">
                <a href="achete1.php?id=144" class="product-link">
                    <img src="imges/t_shirtfemme/16.webp"
                        alt="T-shirt à manches courtes et col ras du cou à imprimé universitaire" class="product-image">
                    <h3 class="product-title">ONLSIMONI - Pullover - pumice stone</h3>
                    <div class="product-price">$49.50</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="144">♥</button>
            </article>



        </div>
    </main>


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
        document.addEventListener('DOMContentLoaded', function () {
            // Wishlist functionality
            const wishlistButtons = document.querySelectorAll('.wishlist-button');
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

            // Initialize wishlist buttons
            function updateWishlistIcons() {
                wishlistButtons.forEach(button => {
                    const productCard = button.closest('.product-card');
                    const product = getProductData(productCard);
                    const isInWishlist = wishlist.some(item => item.id === product.id);

                    button.classList.toggle('active', isInWishlist);
                    button.innerHTML = isInWishlist ? '❤' : '♥';
                });
            }

            // Get product data from card
            function getProductData(productCard) {
                return {
                    id: productCard.querySelector('a').getAttribute('href'),
                    title: productCard.querySelector('.product-title').textContent.trim(),
                    price: getCleanPrice(productCard),
                    image: productCard.querySelector('.product-image').src
                };
            }

            // Extract numeric price
            function getCleanPrice(productCard) {
                const priceElement = productCard.querySelector('.current-price') ||
                    productCard.querySelector('.product-price');
                return parseFloat(priceElement.textContent.replace(/[^0-9.]/g, ''));
            }

            // Handle wishlist button clicks
            wishlistButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const productCard = this.closest('.product-card');
                    const product = getProductData(productCard);

                    const existingIndex = wishlist.findIndex(item => item.id === product.id);

                    if (existingIndex === -1) {
                        // Add to wishlist
                        wishlist.push(product);
                        this.classList.add('active');
                        showWishlistFeedback('Added to wishlist!');
                    } else {
                        // Remove from wishlist
                        wishlist.splice(existingIndex, 1);
                        this.classList.remove('active');
                        showWishlistFeedback('Removed from wishlist');
                    }

                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    this.innerHTML = existingIndex === -1 ? '❤' : '♥';
                });
            });

            // Wishlist feedback notification
            function showWishlistFeedback(message) {
                const feedback = document.createElement('div');
                feedback.className = 'wishlist-feedback';
                feedback.textContent = message;

                document.body.appendChild(feedback);

                setTimeout(() => {
                    feedback.classList.add('show');
                }, 10);

                setTimeout(() => {
                    feedback.classList.remove('show');
                    setTimeout(() => feedback.remove(), 500);
                }, 2000);
            }

            // Initialize on page load
            updateWishlistIcons();

            // Product hover effect for touch devices
            let touchTimer;
            document.addEventListener('touchstart', function (e) {
                if (e.target.closest('.product-card')) {
                    const card = e.target.closest('.product-card');
                    touchTimer = setTimeout(() => {
                        card.classList.add('force-hover');
                    }, 500);
                }
            });

            document.addEventListener('touchend', function (e) {
                clearTimeout(touchTimer);
                const cards = document.querySelectorAll('.product-card.force-hover');
                cards.forEach(card => card.classList.remove('force-hover'));
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
        // Initialize favorites if they don't exist
        if (!localStorage.getItem('favorites')) {
            localStorage.setItem('favorites', JSON.stringify([]));
        }

        // Toggle favorite status
        function toggleFavorite(productCard) {
            const productId = productCard.querySelector('a').getAttribute('href').split('id=')[1];
            const productTitle = productCard.querySelector('.product-title').textContent;
            const productImage = productCard.querySelector('.product-image').src;
            const productPrice = productCard.querySelector('.product-price').textContent;
            const productCategory = window.location.pathname.split('/').pop().replace('.php', '');

            const favorites = JSON.parse(localStorage.getItem('favorites'));
            const existingIndex = favorites.findIndex(item =>
                item.id === productId && item.category === productCategory
            );

            if (existingIndex === -1) {
                // Add to favorites
                favorites.push({
                    id: productId,
                    title: productTitle,
                    image: productImage,
                    price: productPrice,
                    category: productCategory,
                    link: `${productCategory}.php?id=${productId}`
                });
            } else {
                // Remove from favorites
                favorites.splice(existingIndex, 1);
            }

            localStorage.setItem('favorites', JSON.stringify(favorites));
            updateHeartButtons();
        }

        // Update heart button states
        function updateHeartButtons() {
            const favorites = JSON.parse(localStorage.getItem('favorites'));
            const currentCategory = window.location.pathname.split('/').pop().replace('.php', '');

            document.querySelectorAll('.wishlist-button').forEach(button => {
                const productCard = button.closest('.product-card');
                const productId = productCard.querySelector('a').getAttribute('href').split('id=')[1];

                const isFavorite = favorites.some(item =>
                    item.id === productId && item.category === currentCategory
                );

                button.classList.toggle('active', isFavorite);
                button.setAttribute('aria-label', isFavorite ? 'Remove from favorites' : 'Add to favorites');
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            // Set up event listeners for heart buttons
            document.querySelectorAll('.wishlist-button').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    toggleFavorite(this.closest('.product-card'));
                });
            });

            // Initialize heart button states
            updateHeartButtons();
        });
    </script>

</body>
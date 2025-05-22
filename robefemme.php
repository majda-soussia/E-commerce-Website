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
    <meta name="description"
        content="Browse our collection of women's skirts - various styles, colors and sizes available">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="jupefemme.css">
    <title>Women's Skirts Collection </title>
</head>

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
    <!-- Main Content -->
    <main class="main-content">
        <h2 class="page-title">Women's Skirts</h2>


        <div class="product-grid" id="favorites-container">
            <!-- Product 1 -->
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf11.png?id=119" alt="Robe longue femme à col en V" class="product-image">
                    <h3 class="product-title">Robe longue femme à col en V</h3>
                    <div class="product-price">
                        <span class="old-price">$80.35</span>
                        <span class="current-price">$50.30</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="119">♥</button>
            </article>

            <!-- Product 2 -->
            <article class="product-card" data-category="robefemme">
                <a href="achete.html" class="product-link">
                    <img src="imges\robefemme\rf21.png?id=120" alt="Robe courte élégante à imprimé floral"
                        class="product-image">
                    <h3 class="product-title">Robe courte élégante à imprimé floral</h3>
                    <div class="product-price">
                        <span class="old-price">$50.35</span>
                        <span class="current-price">$40.30</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="120">♥</button>
            </article>

            <!-- Product 3 -->
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf31.png?id=121" alt="Robe moulante à manches longues et col rond"
                        class="product-image">
                    <h3 class="product-title">Robe moulante à manches longues et col rond</h3>
                    <div class="product-price">
                        <span class="old-price">$70.35</span>
                        <span class="current-price">$50.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="121">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf41.png?id=122" alt="Robe chemise avec volant à l'ourlet"
                        class="product-image">
                    <h3 class="product-title">Robe chemise avec volant à l'ourlet</h3>
                    <div class="product-price">
                        <span class="old-price">$90.35</span>
                        <span class="current-price">$70.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="122">♥</button>
            </article>
            <article class="product-card">
                <a href="#" class="product-link" data-category="robefemme">
                    <img src="imges\robefemme\rf51.png?id=123" alt="Robe maxi arabe modeste à manches lanternes "
                        class="product-image">
                    <h3 class="product-title">Robe maxi arabe modeste à manches lanternes </h3>
                    <div class="product-price">
                        <span class="old-price">$70.35</span>
                        <span class="current-price">$50.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="123">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf61.png?id=124" alt="set " class="product-image">
                    <h3 class="product-title">Robe ajustée en forme de ligne A bleu marine </h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$55.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="124">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf71.png?id=125" alt="set " class="product-image">
                    <h3 class="product-title"> Robe longue élégante minimaliste à patchwork </h3>
                    <div class="product-price">
                        <span class="old-price">$80.35</span>
                        <span class="current-price">$60.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="125">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf81.png?id=126" alt="set " class="product-image">
                    <h3 class="product-title">Robe à imprimé floral, élégante sans manches</h3>
                    <div class="product-price">
                        <span class="old-price">$90.35</span>
                        <span class="current-price">$60.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="126">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf91.png?id=127" alt="set " class="product-image">
                    <h3 class="product-title">Robe de fête de Noël Robe de cérémonie Réveillon </h3>
                    <div class="product-price">
                        <span class="old-price">$40.35</span>
                        <span class="current-price">$30.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="127">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf101.png?id=128" alt="set " class="product-image">
                    <h3 class="product-title">Robe pour femmes avec col carré bleu, double couche de volants aux manches</h3>
                    <div class="product-price">
                        <span class="old-price">$40.35</span>
                        <span class="current-price">$30.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="128">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf111.png?id=129" alt="set " class="product-image">
                    <h3 class="product-title">Robe à manches longues imprimée élégante pour le printemps</h3>
                    <div class="product-price">
                        <span class="old-price">$70.35</span>
                        <span class="current-price">$65.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="129">♥</button>
            </article>
            <article class="product-card" data-category="robefemme">
                <a href="#" class="product-link">
                    <img src="imges\robefemme\rf121.png?id=130" alt="set " class="product-image">
                    <h3 class="product-title">Robe mi-longue évasée mermaid à col carré en mousseline </h3>
                    <div class="product-price">
                        <span class="old-price">$90.35</span>
                        <span class="current-price">$75.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="130">♥</button>
            </article>
        </div>




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
        // Initialize favorites if they don't exist
        if (!localStorage.getItem('favorites')) {
            localStorage.setItem('favorites', JSON.stringify([]));
        }

        // Function to toggle favorite status
        function toggleFavorite(productCard) {
            const productLink = productCard.querySelector('a.product-link');
            const productId = productLink.getAttribute('href').split('id=')[1] || '1'; // Default ID if none
            const productTitle = productCard.querySelector('.product-title').textContent;
            const productImage = productCard.querySelector('.product-image').src;
            const productPrice = productCard.querySelector('.product-price').textContent;

            // Get current page name (like "t_shirtfemme") without .php
            const productCategory = window.location.pathname
                .split('/')
                .pop()
                .replace('.php', '')
                .replace('.html', '');

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
                    link: productLink.getAttribute('href')
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
            const currentCategory = window.location.pathname
                .split('/')
                .pop()
                .replace('.php', '')
                .replace('.html', '');

            document.querySelectorAll('.wishlist-button').forEach(button => {
                const productCard = button.closest('.product-card');
                const productLink = productCard.querySelector('a.product-link');
                const productId = productLink.getAttribute('href').split('id=')[1] || '1';

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

</html>
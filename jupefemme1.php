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
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=7" class="product-link" >
                    <img src="imges/jupefemme/114.jpg" alt="High-waisted denim skirt" class="product-image">
                    <h3 class="product-title">High-waisted denim skirt</h3>
                    <div class="product-price">$50.99</div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="7">♥</button>
            </article>

            <!-- Product 2 -->
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=11" class="product-link">
                    <img src="imges/jupefemme/113.jpg" alt="Cargo midi skirt" class="product-image">
                    <h3 class="product-title">Cargo midi skirt</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$45.30</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="11">♥</button>
            </article>

            <!-- Product 3 -->
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=12" class="product-link">
                    <img src="imges/jupefemme/112.jpg" alt="Denim midi skirt in beige" class="product-image">
                    <h3 class="product-title">Denim midi skirt in beige</h3>
                    <div class="product-price">
                        <span>$60.35</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="12">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=13" class="product-link">
                    <img src="imges/jupefemme/117.jpg" alt="tshirt " class="product-image">
                    <h3 class="product-title">Jupe midi à poches KAKI</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$49.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="13">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=14" class="product-link">
                    <img src="imges/jupefemme/16.webp" alt="set " class="product-image">
                    <h3 class="product-title" >Jupe midi plissée noir</h3>
                    <div class="product-price">
                        <span class="old-price">$50.35</span>
                        <span class="current-price">$43.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="14">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=15" class="product-link">
                    <img src="imges/jupefemme/118.jpg" alt="set " class="product-image">
                    <h3 class="product-title">Jupe femme Automne Hiver Rétro Taille Haute </h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$50.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="15">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=16" class="product-link">
                    <img src="imges/jupefemme/119.webp" alt="set " class="product-image">
                    <h3 class="product-title">MIDI - Jupe trapèze - medium blue denim </h3>
                    <div class="product-price">
                        <span class="old-price">$40.35</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="15">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=28" class="product-link">
                    <img src="imges/jupefemme/120.webp" alt="set " class="product-image">
                    <h3 class="product-title">Jupe plissée - white </h3>
                    <div class="product-price">
                        <span class="old-price">$40.35</span>
                        <span class="current-price">$35</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="28">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=29" class="product-link">
                    <img src="imges/jupefemme/121.webp" alt="set " class="product-image">
                    <h3>FLOWING BOHO - Jupe longue - white</h3>
                    <div class="product-price">
                        <span class="old-price">$55.35</span>
                        <span class="current-price">$49.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="29">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=10" class="product-link">
                    <img src="imges/jupefemme/122.webp" alt="set " class="product-image">
                    <h3 class="product-title">Jupe trapèze - black </h3>
                    <div class="product-price">
                        <span class="old-price">$40.35</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="10">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=11" class="product-link">
                    <img src="imges/jupefemme/124.webp" alt="set " class="product-image">
                    <h3 class="product-title">WITH DARTS - Jupe longue - khaki </h3>
                    <div class="product-price">
                        <span class="old-price">$50.35</span>
                        <span class="current-price">$39.99</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="11">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=12" class="product-link">
                    <img src="imges/jupefemme/125.webp" alt="set " class="product-image">
                    <h3 class="product-title">Jupe trapèze - red </h3>
                    <div class="product-price">
                        <span class="old-price">$35.35</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="12">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=13" class="product-link">
                    <img src="imges/jupefemme/126.webp" alt="set " class="product-image">
                    <h3 class="product-title">Jupe longue - grey </h3>
                    <div class="product-price">
                        <span class="old-price">$57.35</span>
                        <span class="current-price">$48.5</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="13">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=14" class="product-link">
                    <img src="imges/jupefemme/127.webp" alt="set " class="product-image">
                    <h3 class="product-title">Jupe trapèze - blau </h3>
                    <div class="product-price">
                        <span class="old-price">$40.35</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist" data-product-id="14">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=15" class="product-link">
                    <img src="imges/jupefemme/128.jpg" alt="set " class="product-image">
                    <h3 class="product-title">Koton Femme – Jupe longue en viscose</h3>
                    <div class="product-price">
                        <span class="old-price">$54.35</span>
                        <span class="current-price">$46.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=16" class="product-link">
                    <img src="imges/jupefemme/1.jpg" alt="set " class="product-image">
                    <h3 class="product-title"> Short large en twill Beige</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=17" class="product-link">
                    <img src="imges/jupefemme/2.jpg" alt="set " class="product-image">
                    <h3 class="product-title"> Jupe taille haute en jean Brut</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=18" class="product-link">
                    <img src="imges/jupefemme/3.jpg" alt="set " class="product-image">
                    <h3> Mini-jupe à volants en tissu modal volumineux superposé</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=19" class="product-link">
                    <img src="imges/jupefemme/4.jpg" alt="set " class="product-image">
                    <h3> Mini-jupe </h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=20" class="product-link">
                    <img src="imges/jupefemme/6.jpeg" alt="set " class="product-image">
                    <h3> Jupe midi pour femme effet cuir</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=21" class="product-link">
                    <img src="imges/jupefemme/5.avif" alt="set " class="product-image">
                    <h3> Jupe longue en gaze de coton avec volants étagés</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card" data-category="jupefemme">
                <a href="achete1.php?id=22" class="product-link">
                    <img src="imges/jupefemme/7.jpg" alt="set " class="product-image">
                    <h3> Jupe short avec boutons bijoux noir</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.php?id=23" class="product-link">
                    <img src="imges/jupefemme/8.jpg" alt="set " class="product-image">
                    <h3>Jupe midi en maille crêpe</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.php?id=24" class="product-link">
                    <img src="imges/jupefemme/9.avif" alt="set " class="product-image">
                    <h3>Jupe longue en jean à empiècements</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.php?id=25" class="product-link">
                    <img src="imges/jupefemme/10.avif" alt="set " class="product-image">
                    <h3>Jupe longue à ourlet contrastant </h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.php?id=26" class="product-link">
                    <img src="imges/jupefemme/12.jpg" alt="set " class="product-image">
                    <h3>Jupe évasée fluide et légère </h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.php?id=27" class="product-link">
                    <img src="imges/jupefemme/13.jpg" alt="set " class="product-image">
                    <h3>Jupe Courte Plissée Mini Carreaux Ceinturée Coupe Slim </h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
            </article>
            <article class="product-card">
                <a href="achete1.php?id=28" class="product-link">
                    <img src="imges/jupefemme/14.jpg" alt="set " class="product-image">
                    <h3> Mini-jupe en tweed coupe trapèze avec poche à rabat détaillée</h3>
                    <div class="product-price">
                        <span class="old-price">$60.35</span>
                        <span class="current-price">$90.15</span>
                    </div>
                </a>
                <button class="wishlist-button" aria-label="Add to wishlist">♥</button>
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

</html>
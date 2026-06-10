<!-- Footer -->
<footer class="footer">
    <div class="container">
        <!-- Colonne 1 : A propos + reseaux sociaux -->
        <div class="footer-col">
            <div class="footer-logo">
                <img src="assets/images/logo.svg" alt="ParaCare">
                <span>ParaCare</span>
            </div>
            <p>Votre parapharmacie en ligne de confiance. Des produits de qualité pharmaceutique pour prendre soin de votre santé et beauté.</p>
            <div class="footer-social">
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <!-- Colonne 2 : Liens rapides -->
        <div class="footer-col">
            <h4>Navigation</h4>
            <ul>
                <li><a href="index.php"><i class="fas fa-chevron-right"></i> Accueil</a></li>
                <li><a href="index.php?page=produits"><i class="fas fa-chevron-right"></i> Nos Produits</a></li>
                <li><a href="index.php?page=panier"><i class="fas fa-chevron-right"></i> Mon Panier</a></li>
                <li><a href="index.php?page=commande"><i class="fas fa-chevron-right"></i> Mes Commandes</a></li>
            </ul>
        </div>

        <!-- Colonne 3 : Categories -->
        <div class="footer-col">
            <h4>Catégories</h4>
            <ul>
                <li><a href="index.php?page=produits&cat=skincare"><i class="fas fa-chevron-right"></i> Skincare</a></li>
                <li><a href="index.php?page=produits&cat=haircare"><i class="fas fa-chevron-right"></i> Haircare</a></li>
                <li><a href="index.php?page=produits&cat=body-care"><i class="fas fa-chevron-right"></i> Body Care</a></li>
                <li><a href="index.php?page=produits&cat=vitamins"><i class="fas fa-chevron-right"></i> Vitamines</a></li>
            </ul>
        </div>

        <!-- Colonne 4 : Contact + Newsletter -->
        <div class="footer-col">
            <h4>Contact</h4>
            <ul class="footer-contact">
                <li><i class="fas fa-envelope"></i> contact@paracare.com</li>
                <li><i class="fas fa-phone"></i> +212 6 00 00 00 00</li>
                <li><i class="fas fa-map-marker-alt"></i> Casablanca, Maroc</li>
                <li><i class="fas fa-clock"></i> Lun - Sam : 9h - 19h</li>
            </ul>

            <div class="footer-newsletter">
                <h4>Newsletter</h4>
                <p class="newsletter-text">Recevez nos offres et nouveautés</p>
                <form class="newsletter-form" onsubmit="return inscrireNewsletter(event)">
                    <input type="email" id="newsletterEmail" placeholder="Votre email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
                <p id="newsletterMsg" class="newsletter-msg"></p>
            </div>
        </div>
    </div>

    <!-- Paiement et copyright -->
    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <div class="footer-payment">
                <span class="payment-label">Paiement sécurisé :</span>
                <span class="payment-icons">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fas fa-money-bill-wave"></i>
                </span>
            </div>
            <p>&copy; <?php echo date('Y'); ?> ParaCare - Tous droits réservés</p>
        </div>
    </div>
</footer>

<!-- JavaScript -->
<script src="assets/js/script.js"></script>
</body>
</html>

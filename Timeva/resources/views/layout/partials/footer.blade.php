<footer class="footer-elegant">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            
            <!-- À propos -->
            <section>
                <h3 class="footer-brand">
                    TIMEVA
                </h3>
                <p class="footer-description">
                    Votre destination pour les montres et lunettes de luxe. Qualité, élégance et style depuis 2026.
                </p>
                <div class="flex gap-4 mt-6">
                    <a href="#" class="social-icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                </div>
            </section>

            <!-- Navigation -->
            <section>
                <h3 class="footer-title">Navigation</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('products.watches') }}">Montres</a></li>
                    <li><a href="{{ route('products.glasses') }}">Lunettes</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </section>

            <!-- Mon compte -->
            <section>
                <h3 class="footer-title">Mon Compte</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('profile.index') }}">Profil</a></li>
                    <li><a href="{{ route('profile.orders') }}">Mes commandes</a></li>
                    <li><a href="{{ route('cart.index') }}">Mon panier</a></li>
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                </ul>
            </section>

            <!-- Contact -->
            <section>
                <h3 class="footer-title">Contact</h3>
                <ul class="footer-contact">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>12 Rue de la Paix<br>Cotonou, Bénin</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:contact@timeva.com" class="hover:text-gray-900 transition-colors">contact@timeva.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:+22901658056991" class="hover:text-gray-900 transition-colors">+229 01 65 80 56 91</a>
                    </li>
                </ul>
            </section>
        </div>

        <!-- Séparateur -->
        <div class="border-t border-gray-300 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="footer-copyright">
                    © 2026 <span class="font-semibold">TIMEVA</span>. Tous droits réservés.
                </p>
                <div class="flex gap-6 text-sm">
                    <a href="#" class="footer-legal-link">Politique de confidentialité</a>
                    <a href="#" class="footer-legal-link">Conditions générales</a>
                    <a href="#" class="footer-legal-link">Mentions légales</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* Import des polices élégantes */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:wght@400;500;600&display=swap');

/* Footer Background */
.footer-elegant {
    background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
    border-top: 1px solid #e5e7eb;
}

/* Footer Brand */
.footer-brand {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    letter-spacing: 0.15em;
    margin-bottom: 1rem;
    text-transform: uppercase;
}

/* Footer Description */
.footer-description {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.95rem;
    color: #6b7280;
    line-height: 1.6;
}

/* Footer Titles */
.footer-title {
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 1rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

/* Footer Links */
.footer-links {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.footer-links li a {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.95rem;
    color: #6b7280;
    transition: all 0.3s ease;
    position: relative;
    display: inline-block;
}

.footer-links li a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: #111827;
    transition: width 0.3s ease;
}

.footer-links li a:hover {
    color: #111827;
}

.footer-links li a:hover::after {
    width: 100%;
}

/* Footer Contact */
.footer-contact {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.footer-contact li {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.95rem;
    color: #6b7280;
    line-height: 1.5;
}

/* Social Icons */
.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    background: #ffffff;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: #111827;
    color: white;
    border-color: #111827;
    transform: translateY(-3px);
}

/* Footer Copyright */
.footer-copyright {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.9rem;
    color: #6b7280;
}

/* Footer Legal Links */
.footer-legal-link {
    font-family: 'Cormorant Garamond', serif;
    color: #6b7280;
    transition: color 0.3s ease;
}

.footer-legal-link:hover {
    color: #111827;
}
</style>
<footer class="bg-gray-50 border-t mt-12">
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- À propos -->
        <section>
            <h3 class="font-bold text-gray-900 text-lg mb-2 flex items-center gap-2">
                <span></span> Timeva
            </h3>
            <p class="text-gray-500 text-sm">
                Votre destination pour les montres et lunettes de luxe. Qualité, élégance et style depuis 2026.
            </p>
        </section>

        <!-- Navigation -->
        <section>
            <h3 class="font-semibold text-gray-900 mb-2">Navigation</h3>
            <div class="flex flex-col space-y-1 text-gray-500 text-sm">
                <a href="{{ route('home') }}" class="hover:text-gray-900">Accueil</a>
                <a href="{{ route('products.watches') }}" class="hover:text-gray-900">Montres</a>
                <a href="{{ route('products.glasses') }}" class="hover:text-gray-900">Lunettes</a>
            </div>
        </section>

        <!-- Mon compte -->
        <section>
            <h3 class="font-semibold text-gray-900 mb-2">Mon Compte</h3>
            <div class="flex flex-col space-y-1 text-gray-500 text-sm">
                <a href="{{ route('profile') }}" class="hover:text-gray-900">Profil</a>
                <a href="{{ route('profile.orders') }}" class="hover:text-gray-900">Mes commandes</a>
                <a href="{{ route('cart') }}" class="hover:text-gray-900">Mon panier</a>
            </div>
        </section>

        <!-- Contact -->
        <section>
            <h3 class="font-semibold text-gray-900 mb-2">Contact</h3>
            <div class="text-gray-500 text-sm space-y-1">
                <p>12 Rue de la Paix, Cotonou</p>
                <p>Email: contact@timeva.com</p>
                <p>Téléphone: +229 01 65 80 56 91</p>
            </div>
        </section>
    </div>

    <div class="border-t border-gray-200 mt-6 py-4 text-center text-gray-500 text-sm">
        &copy; 2026 Timeva. Tous droits réservés.
    </div>
</footer>
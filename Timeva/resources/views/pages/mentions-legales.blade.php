@extends('layout.app')

@section('title', 'Mentions légales — TIMEVA')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-3xl mx-auto">

        <div class="mb-10">
            <p class="text-sm text-gray-400 mb-2">Dernière mise à jour : janvier 2026</p>
            <h1 class="text-4xl font-bold text-gray-900">Mentions légales</h1>
        </div>

        <div class="space-y-8 text-gray-700 leading-relaxed">

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">1. Éditeur du site</h2>
                <div class="bg-gray-50 rounded-xl p-6 space-y-2 text-sm">
                    <p><strong>Raison sociale :</strong> TIMEVA</p>
                    <p><strong>Forme juridique :</strong> Entreprise individuelle</p>
                    <p><strong>Siège social :</strong> 12 Rue de la Paix, Cotonou, Bénin</p>
                    <p><strong>Email :</strong> <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a></p>
                    <p><strong>Téléphone :</strong> <a href="tel:+22901658056991" class="underline hover:text-gray-900">+229 01 65 80 56 91</a></p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">2. Directeur de la publication</h2>
                <p>Le directeur de la publication est le représentant légal de TIMEVA, joignable à l'adresse email <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">3. Hébergement</h2>
                <div class="bg-gray-50 rounded-xl p-6 space-y-2 text-sm">
                    <p><strong>Hébergeur :</strong> À préciser selon votre hébergeur (ex. OVH, DigitalOcean…)</p>
                    <p><strong>Adresse :</strong> À compléter</p>
                    <p><strong>Site web :</strong> À compléter</p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">4. Propriété intellectuelle</h2>
                <p>L'ensemble du contenu de ce site (textes, images, logos, icônes, structure) est la propriété exclusive de TIMEVA et est protégé par les lois en vigueur relatives à la propriété intellectuelle. Toute reproduction, représentation ou diffusion, même partielle, est strictement interdite sans autorisation préalable et écrite de TIMEVA.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">5. Données personnelles</h2>
                <p>Le traitement des données personnelles collectées via ce site est détaillé dans notre <a href="{{ route('pages.confidentialite') }}" class="underline hover:text-gray-900">Politique de confidentialité</a>. Conformément à la réglementation applicable, vous pouvez exercer vos droits en contactant <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">6. Cookies</h2>
                <p>Ce site utilise uniquement des cookies techniques nécessaires au fonctionnement du service (session, panier). Pour en savoir plus, consultez notre <a href="{{ route('pages.confidentialite') }}" class="underline hover:text-gray-900">Politique de confidentialité</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">7. Liens hypertextes</h2>
                <p>Ce site peut contenir des liens vers des sites tiers. TIMEVA ne peut être tenu responsable du contenu de ces sites externes et n'exerce aucun contrôle sur ceux-ci.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">8. Limitation de responsabilité</h2>
                <p>TIMEVA s'efforce de maintenir les informations de ce site à jour et exactes. Toutefois, des erreurs ou omissions peuvent survenir. TIMEVA ne saurait être tenu responsable des dommages résultant d'une indisponibilité du site ou d'informations inexactes.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">9. Droit applicable et juridiction</h2>
                <p>Les présentes mentions légales sont régies par le droit béninois. En cas de litige, les tribunaux compétents de Cotonou, Bénin, seront seuls compétents.</p>
            </section>

        </div>

        <div class="mt-12 pt-8 border-t border-gray-200 flex gap-4">
            <a href="{{ route('pages.confidentialite') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">Politique de confidentialité →</a>
            <a href="{{ route('pages.conditions') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">Conditions générales →</a>
        </div>
    </div>
</div>
@endsection

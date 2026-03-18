@extends('layout.app')

@section('title', 'Politique de confidentialité — TIMEVA')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-3xl mx-auto">

        <div class="mb-10">
            <p class="text-sm text-gray-400 mb-2">Dernière mise à jour : janvier 2026</p>
            <h1 class="text-4xl font-bold text-gray-900">Politique de confidentialité</h1>
        </div>

        <div class="prose prose-gray max-w-none space-y-8 text-gray-700 leading-relaxed">

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">1. Qui sommes-nous ?</h2>
                <p>TIMEVA est une boutique en ligne spécialisée dans la vente de montres et lunettes de luxe, dont le siège social est situé au 12 Rue de la Paix, Cotonou, Bénin. Email : <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">2. Données collectées</h2>
                <p class="mb-3">Dans le cadre de notre activité, nous collectons les données suivantes :</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Données d'identification :</strong> nom, prénom, adresse email, numéro de téléphone.</li>
                    <li><strong>Données de livraison :</strong> adresse postale, code postal, pays.</li>
                    <li><strong>Données de paiement :</strong> traitées exclusivement par FedaPay. TIMEVA ne stocke aucune donnée bancaire.</li>
                    <li><strong>Données de navigation :</strong> adresse IP, pages visitées, durée de session (via les logs serveur).</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">3. Finalités du traitement</h2>
                <p class="mb-3">Vos données sont utilisées pour :</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Créer et gérer votre compte client.</li>
                    <li>Traiter et suivre vos commandes.</li>
                    <li>Vous envoyer des confirmations de commande par email.</li>
                    <li>Répondre à vos demandes de support.</li>
                    <li>Améliorer nos services et l'expérience utilisateur.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">4. Durée de conservation</h2>
                <p>Vos données sont conservées pendant la durée de votre relation commerciale avec TIMEVA, augmentée de 3 ans à des fins de gestion des litiges, conformément à la législation béninoise applicable.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">5. Partage des données</h2>
                <p class="mb-3">Vos données ne sont jamais vendues à des tiers. Elles peuvent être partagées uniquement avec :</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>FedaPay</strong> — pour le traitement sécurisé des paiements.</li>
                    <li><strong>Prestataires logistiques</strong> — pour l'acheminement de vos commandes.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">6. Vos droits</h2>
                <p class="mb-3">Conformément à la réglementation applicable, vous disposez des droits suivants :</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Droit d'accès à vos données personnelles.</li>
                    <li>Droit de rectification des données inexactes.</li>
                    <li>Droit à l'effacement ("droit à l'oubli").</li>
                    <li>Droit à la portabilité de vos données.</li>
                    <li>Droit d'opposition au traitement.</li>
                </ul>
                <p class="mt-3">Pour exercer ces droits, contactez-nous à <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">7. Sécurité</h2>
                <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, perte ou divulgation. Les mots de passe sont stockés sous forme hachée et les paiements sont chiffrés via HTTPS.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">8. Cookies</h2>
                <p>Notre site utilise des cookies de session nécessaires au bon fonctionnement du panier et de l'authentification. Aucun cookie publicitaire ou de tracking tiers n'est utilisé.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">9. Contact</h2>
                <p>Pour toute question relative à cette politique, contactez notre responsable de traitement à l'adresse : <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a> ou au +229 01 65 80 56 91.</p>
            </section>

        </div>

        <div class="mt-12 pt-8 border-t border-gray-200 flex gap-4">
            <a href="{{ route('pages.conditions') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">Conditions générales →</a>
            <a href="{{ route('pages.mentions') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">Mentions légales →</a>
        </div>
    </div>
</div>
@endsection

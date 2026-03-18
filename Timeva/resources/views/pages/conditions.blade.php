@extends('layout.app')

@section('title', 'Conditions générales de vente — TIMEVA')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-3xl mx-auto">

        <div class="mb-10">
            <p class="text-sm text-gray-400 mb-2">En vigueur depuis janvier 2026</p>
            <h1 class="text-4xl font-bold text-gray-900">Conditions générales de vente</h1>
        </div>

        <div class="space-y-8 text-gray-700 leading-relaxed">

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">1. Objet</h2>
                <p>Les présentes conditions générales de vente (CGV) régissent les relations contractuelles entre TIMEVA (ci-après "le Vendeur") et tout client (ci-après "l'Acheteur") passant commande sur le site <strong>timeva.com</strong>. Toute commande implique l'acceptation sans réserve des présentes CGV.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">2. Produits</h2>
                <p>Les produits proposés sont des montres et lunettes présentés avec leurs caractéristiques essentielles (description, prix, disponibilité par variante). TIMEVA se réserve le droit de modifier son catalogue à tout moment. Les photos sont non contractuelles.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">3. Prix</h2>
                <p>Les prix sont indiqués en <strong>Francs CFA (FCFA)</strong>, toutes taxes comprises. TIMEVA se réserve le droit de modifier ses prix à tout moment ; les produits sont facturés sur la base des tarifs en vigueur au moment de la validation de la commande.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">4. Commande</h2>
                <p class="mb-3">Le processus de commande se déroule comme suit :</p>
                <ol class="list-decimal pl-6 space-y-2">
                    <li>Sélection du produit et de la variante (couleur, taille).</li>
                    <li>Ajout au panier et vérification du récapitulatif.</li>
                    <li>Saisie de l'adresse de livraison.</li>
                    <li>Paiement sécurisé via FedaPay.</li>
                    <li>Confirmation par email après validation du paiement.</li>
                </ol>
                <p class="mt-3">La commande est considérée comme définitive après réception du paiement et envoi de l'email de confirmation.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">5. Paiement</h2>
                <p>Le paiement s'effectue via la plateforme <strong>FedaPay</strong>, qui accepte les paiements par Mobile Money (MTN, Moov), carte bancaire et autres moyens disponibles. Toutes les transactions sont sécurisées et chiffrées. TIMEVA ne stocke aucune donnée de paiement.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">6. Livraison</h2>
                <p class="mb-3">Les livraisons sont effectuées à l'adresse indiquée lors de la commande. Les délais estimés sont :</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Cotonou et environs :</strong> 24 à 48 heures ouvrables.</li>
                    <li><strong>Reste du Bénin :</strong> 3 à 5 jours ouvrables.</li>
                    <li><strong>Afrique de l'Ouest :</strong> 5 à 10 jours ouvrables.</li>
                </ul>
                <p class="mt-3">La livraison est offerte sur toutes les commandes.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">7. Droit de rétractation et retours</h2>
                <p>L'Acheteur dispose d'un délai de <strong>7 jours</strong> à compter de la réception pour retourner un article en parfait état, dans son emballage d'origine, contre remboursement ou échange. Les frais de retour sont à la charge de l'Acheteur. Les articles personnalisés ou descellés ne sont pas repris.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">8. Annulation de commande</h2>
                <p>Une commande peut être annulée via l'espace "Mes commandes" tant que son statut est "<strong>En attente</strong>". Passé ce stade, l'annulation doit être demandée par email à <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">9. Garantie et responsabilité</h2>
                <p>Tous les produits bénéficient d'une garantie de <strong>12 mois</strong> contre les défauts de fabrication. La garantie ne couvre pas les dommages résultant d'un usage anormal, d'accidents ou d'une usure normale.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">10. Droit applicable</h2>
                <p>Les présentes CGV sont soumises au droit béninois. En cas de litige, les parties chercheront une résolution amiable avant tout recours judiciaire. À défaut, les tribunaux compétents de Cotonou seront seuls compétents.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">11. Contact</h2>
                <p>Pour toute question relative à ces conditions : <a href="mailto:contact@timeva.com" class="underline hover:text-gray-900">contact@timeva.com</a> — +229 01 65 80 56 91.</p>
            </section>

        </div>

        <div class="mt-12 pt-8 border-t border-gray-200 flex gap-4">
            <a href="{{ route('pages.confidentialite') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">Politique de confidentialité →</a>
            <a href="{{ route('pages.mentions') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">Mentions légales →</a>
        </div>
    </div>
</div>
@endsection

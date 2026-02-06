@extends('profile.layout')

@section('profile-content')
<div class="bg-white border border-gray-200 rounded-lg p-8">
    <div class="space-y-6">

        <!-- Commande 1 -->
        <div class="border border-gray-200 rounded-lg p-6">
            <!-- En-tête de commande -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold mb-1">Commande #CMD-001245</h3>
                    <p class="text-sm text-gray-500">29 janvier 2026</p>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                    Livrée
                </span>
            </div>

            <!-- Liste des produits -->
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between">
                    <p class="text-gray-700">
                        Cat Eye Élégance (Noir - Standard) × 2
                    </p>
                    <p class="font-medium">560.00 €</p>
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-gray-700">
                        Carré Minimaliste (Gris - Standard) × 1
                    </p>
                    <p class="font-medium">245.00 €</p>
                </div>
            </div>

            <!-- Total -->
            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-bold">Total</p>
                    <p class="text-xl font-bold">805.00 €</p>
                </div>
            </div>
        </div>

        <!-- Commande 2 -->
        <div class="border border-gray-200 rounded-lg p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold mb-1">Commande #CMD-001198</h3>
                    <p class="text-sm text-gray-500">12 janvier 2026</p>
                </div>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">
                    En cours
                </span>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between">
                    <p class="text-gray-700">
                        Lunettes Vintage (Marron - Standard) × 1
                    </p>
                    <p class="font-medium">180.00 €</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-bold">Total</p>
                    <p class="text-xl font-bold">180.00 €</p>
                </div>
            </div>
        </div>

        <!-- Aucune commande (frontend only) -->
        <div class="text-center py-12 hidden">
            <p class="text-gray-500 mb-4">Vous n'avez pas encore de commandes</p>
            <a href="#" class="text-gray-900 hover:underline font-medium">
                Commencer mes achats
            </a>
        </div>

    </div>
</div>
@endsection

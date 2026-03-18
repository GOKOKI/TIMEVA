@extends('layout.app')

@section('title', 'Contact — TIMEVA')

@section('content')
<div class="container mx-auto px-4 py-16">

    {{-- En-tête --}}
    <div class="max-w-2xl mx-auto text-center mb-14">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h1>
        <p class="text-gray-500 text-lg">Une question, une réclamation ou simplement envie de nous écrire ? Nous sommes à votre écoute.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-5xl mx-auto">

        {{-- ===== INFOS DE CONTACT ===== --}}
        <div class="space-y-8">

            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Adresse</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">12 Rue de la Paix<br>Cotonou, Bénin</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                    <a href="mailto:contact@timeva.com" class="text-gray-500 text-sm hover:text-gray-900 transition-colors">
                        contact@timeva.com
                    </a>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Téléphone</h3>
                    <a href="tel:+22901658056991" class="text-gray-500 text-sm hover:text-gray-900 transition-colors">
                        +229 01 65 80 56 91
                    </a>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Horaires</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Lun – Ven : 08h00 – 18h00<br>
                        Sam : 09h00 – 14h00
                    </p>
                </div>
            </div>

        </div>

        {{-- ===== FORMULAIRE ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-200 rounded-2xl p-8">

                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm mb-6">
                    ✓ Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm mb-6">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 @error('prenom') border-red-400 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 @error('nom') border-red-400 @enderror">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 @error('email') border-red-400 @enderror">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sujet <span class="text-red-500">*</span></label>
                        <select name="sujet" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            <option value="">Sélectionner un sujet...</option>
                            <option value="commande"     {{ old('sujet') === 'commande'     ? 'selected' : '' }}>Question sur une commande</option>
                            <option value="produit"      {{ old('sujet') === 'produit'      ? 'selected' : '' }}>Question sur un produit</option>
                            <option value="livraison"    {{ old('sujet') === 'livraison'    ? 'selected' : '' }}>Livraison et retours</option>
                            <option value="paiement"     {{ old('sujet') === 'paiement'     ? 'selected' : '' }}>Problème de paiement</option>
                            <option value="autre"        {{ old('sujet') === 'autre'        ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                                  placeholder="Décrivez votre demande en détail..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-gray-900 text-white py-4 rounded-full font-semibold hover:bg-black transition-colors">
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('profile.layout')

@section('title', 'Mon profil')

@section('profile-content')
<div class="bg-white border border-gray-200 rounded-xl p-8">
    <h2 class="text-2xl font-bold mb-6">Informations personnelles</h2>

    @if($errors->any())
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-600">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    @if(session('success'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-sm text-green-600">{{ session('success') }}</p>
    </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Prénom + Nom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                <input type="text" id="prenom" name="prenom"
                       value="{{ old('prenom', $profil->prenom ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('prenom') border-red-400 @enderror">
                @error('prenom') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                <input type="text" id="nom" name="nom"
                       value="{{ old('nom', $profil->nom ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('nom') border-red-400 @enderror">
                @error('nom') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Email (lecture seule) --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" value="{{ Auth::user()->email }}" readonly
                   class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg text-gray-500 cursor-not-allowed">
            <p class="text-xs text-gray-400 mt-1">L'email ne peut pas être modifié.</p>
        </div>

        {{-- Téléphone --}}
        <div class="mb-6">
            <label for="tel" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
            <input type="tel" id="tel" name="tel"
                   value="{{ old('tel', $profil->tel ?? '') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('tel') border-red-400 @enderror">
            @error('tel') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Adresse --}}
        <div class="mb-6">
            <label for="adresse" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
            <input type="text" id="adresse" name="adresse"
                   value="{{ old('adresse', $profil->adresse ?? '') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('adresse') border-red-400 @enderror">
            @error('adresse') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Ville + Code postal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="ville" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                <input type="text" id="ville" name="ville"
                       value="{{ old('ville', $profil->ville ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('ville') border-red-400 @enderror">
                @error('ville') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                <input type="text" id="code_postal" name="code_postal"
                       value="{{ old('code_postal', $profil->code_postal ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 @error('code_postal') border-red-400 @enderror">
                @error('code_postal') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <input type="hidden" name="pays" value="{{ old('pays', $profil->pays ?? 'Bénin') }}">

        <button type="submit"
                class="bg-gray-900 text-white px-8 py-3 rounded-full hover:bg-black transition-colors font-medium">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection

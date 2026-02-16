@extends('layout.app')

@section('title', 'Inscription - TIMEVA')

@section('content')
<div class="auth-container">
    <section class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Inscription</h2>
            <p class="auth-subtitle">Créez votre compte <span class="brand-name">TIMEVA</span></p>
        </div>

        {{-- Messages d'erreur --}}
        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p class="alert-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="auth-form">
            @csrf

            <!-- Nom -->
            <div class="form-group">
                <label for="name" class="form-label">Nom</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required 
                           placeholder="Jean"
                           class="form-input @error('name') input-error @enderror">
                </div>
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prénom -->
            <div class="form-group">
                <label for="Prenom" class="form-label">Prénom</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input type="text" 
                           id="Prenom" 
                           name="Prenom" 
                           value="{{ old('Prenom') }}"
                           required 
                           placeholder="Dupont"
                           class="form-input @error('Prenom') input-error @enderror">
                </div>
                @error('Prenom')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required 
                           placeholder="votre@email.com"
                           class="form-input @error('email') input-error @enderror">
                </div>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           placeholder="••••••••"
                           class="form-input @error('password') input-error @enderror">
                </div>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation mot de passe -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           placeholder="••••••••"
                           class="form-input">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                S'inscrire
            </button>
        </form>

        <div class="auth-footer">
            <p class="footer-text">
                Déjà un compte ? 
                <a href="{{ route('login') }}" class="footer-link">
                    Se connecter
                </a>
            </p>
        </div>
    </section>
</div>

<style>
/* Import des polices élégantes */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;500;600&display=swap');

/* Container */
.auth-container {
    min-height: calc(100vh - 4rem);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    padding: 2rem 1rem;
}

/* Card */
.auth-card {
    width: 100%;
    max-width: 28rem;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem 2.5rem;
}

/* Header */
.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-title {
    font-family: 'Cinzel', serif;
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.5rem;
    letter-spacing: 0.05em;
}

.auth-subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    color: #6b7280;
}

.brand-name {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.1em;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
}

.alert-text {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.9rem;
    color: #991b1b;
}

/* Form */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.95rem;
    font-weight: 600;
    color: #374151;
    letter-spacing: 0.02em;
}

/* Input Wrapper */
.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1.25rem;
    height: 1.25rem;
    color: #9ca3af;
    pointer-events: none;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-input:focus {
    outline: none;
    border-color: #111827;
    background: white;
    box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

.input-error {
    border-color: #ef4444;
    background: #fef2f2;
}

.error-message {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.875rem;
    color: #dc2626;
    margin-top: 0.25rem;
}

/* Submit Button */
.btn-submit {
    width: 100%;
    padding: 1rem;
    margin-top: 0.5rem;
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    color: white;
    background: #111827;
    border: none;
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    background: #1f2937;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Footer */
.auth-footer {
    margin-top: 2rem;
    text-align: center;
}

.footer-text {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.95rem;
    color: #6b7280;
}

.footer-link {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.05em;
    transition: color 0.3s ease;
}

.footer-link:hover {
    color: #374151;
    text-decoration: underline;
}
</style>
@endsection
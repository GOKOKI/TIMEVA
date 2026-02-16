@extends('layout.app')

@section('title', 'Mot de passe oublié - TIMEVA')

@section('content')
<div class="auth-container">
    <section class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Mot de passe oublié</h2>
            <p class="auth-subtitle">
                Entrez votre email pour recevoir un lien de réinitialisation <span class="brand-name">TIMEVA</span>
            </p>
        </div>


        @if (session('status'))
            <div class="alert alert-success">
                <p class="alert-text">{{ session('status') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p class="alert-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('forgot.send') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email" id="email" name="email" class="form-input" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn-submit">Envoyer le lien</button>
        </form>

        <div class="auth-footer">
            <p class="footer-text">
                Vous vous souvenez de votre mot de passe ?
                <a href="{{ route('login') }}" class="footer-link">Retour à la connexion</a>
            </p>
        </div>
    </section>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;500;600&display=swap');

.auth-container {
    min-height: calc(100vh - 4rem);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    padding: 2rem 1rem;
}

.auth-card {
    width: 100%;
    max-width: 28rem;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem 2.5rem;
}

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

.alert {
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
}

.alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.alert-text {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.9rem;
    color: #991b1b;
}

.alert-success .alert-text {
    color: #166534;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
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
}

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

.input-error {
    border-color: #ef4444;
    background: #fef2f2;
}

.error-message {
    font-family: 'Cormorant Garamond', serif;
    font-size: 0.875rem;
    color: #dc2626;
}

.btn-submit {
    width: 100%;
    padding: 1rem;
    margin-top: 0.5rem;
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    font-weight: 600;
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
}

.footer-link:hover {
    color: #374151;
    text-decoration: underline;
}
</style>
@endsection

@extends('layout.app')

@section('title', 'Réinitialisation du mot de passe - TIMEVA')

@section('content')
<div class="auth-container">
    <section class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Nouveau mot de passe</h2>
            <p class="auth-subtitle">Choisissez un nouveau mot de passe pour votre compte <span class="brand-name">TIMEVA</span></p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p class="alert-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-input" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input type="password" id="password" name="password"
                           class="form-input" required minlength="8">
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-input" required minlength="8">
                </div>
            </div>

            <button type="submit" class="btn-submit">Réinitialiser le mot de passe</button>
        </form>

        <div class="auth-footer">
            <p class="footer-text">
                <a href="{{ route('login') }}" class="footer-link">Retour à la connexion</a>
            </p>
        </div>
    </section>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;500;600&display=swap');
.auth-container{min-height:calc(100vh - 4rem);display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f9fafb 0%,#f3f4f6 100%);padding:2rem 1rem}
.auth-card{width:100%;max-width:28rem;background:white;border-radius:1.5rem;box-shadow:0 10px 40px rgba(0,0,0,.1);padding:3rem 2.5rem}
.auth-header{text-align:center;margin-bottom:2rem}
.auth-title{font-family:'Cinzel',serif;font-size:2rem;font-weight:700;color:#111827;margin-bottom:.5rem;letter-spacing:.05em}
.auth-subtitle{font-family:'Cormorant Garamond',serif;font-size:1rem;color:#6b7280}
.brand-name{font-family:'Cinzel',serif;font-weight:600;color:#111827;letter-spacing:.1em}
.alert{padding:1rem;border-radius:.75rem;margin-bottom:1.5rem}
.alert-error{background:#fef2f2;border:1px solid #fecaca}
.alert-text{font-family:'Cormorant Garamond',serif;font-size:.9rem;color:#991b1b}
.auth-form{display:flex;flex-direction:column;gap:1.5rem}
.form-group{display:flex;flex-direction:column;gap:.5rem}
.form-label{font-family:'Cormorant Garamond',serif;font-size:.95rem;font-weight:600;color:#374151}
.input-wrapper{position:relative}
.input-icon{position:absolute;left:1rem;top:50%;transform:translateY(-50%);width:1.25rem;height:1.25rem;color:#9ca3af;pointer-events:none}
.form-input{width:100%;padding:.875rem 1rem .875rem 3rem;font-family:'Cormorant Garamond',serif;font-size:1rem;border:2px solid #e5e7eb;border-radius:.75rem;transition:all .3s;background:#fafafa}
.form-input:focus{outline:none;border-color:#111827;background:white;box-shadow:0 0 0 3px rgba(17,24,39,.1)}
.btn-submit{width:100%;padding:1rem;margin-top:.5rem;font-family:'Cinzel',serif;font-size:1rem;font-weight:600;color:white;background:#111827;border:none;border-radius:.75rem;cursor:pointer;transition:all .3s}
.btn-submit:hover{background:#1f2937;transform:translateY(-2px);box-shadow:0 10px 20px rgba(0,0,0,.15)}
.auth-footer{margin-top:2rem;text-align:center}
.footer-text{font-family:'Cormorant Garamond',serif;font-size:.95rem;color:#6b7280}
.footer-link{font-family:'Cinzel',serif;font-weight:600;color:#111827;letter-spacing:.05em}
</style>
@endsection

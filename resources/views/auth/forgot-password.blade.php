@extends('layouts.auth')

@section('title', 'Forgot Password - Anagata Executive')
@section('body_class', 'page forgot-password-page')

@section('content')
    {{-- Toast Notifications --}}
    @if (session('status'))
        <div class="toast-stack" data-toast>
            <div class="toast toast--{{ session('toast_type', 'success') }}" role="status" aria-live="polite">
                <div class="toast__icon">
                    @if (session('toast_type', 'success') === 'success')
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    @elseif (session('toast_type') === 'warning')
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                    @else
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    @endif
                </div>
                <div class="toast__body">
                    <p class="toast__title">
                        @if (session('toast_type', 'success') === 'success')
                            Success
                        @elseif (session('toast_type') === 'warning')
                            Warning
                        @else
                            Error
                        @endif
                    </p>
                    <p class="toast__message">{{ session('status') }}</p>
                </div>
                <button type="button" class="toast__close" aria-label="Close toast">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    @endif

    @if ($errors->any() && !session('status'))
        <div class="toast-stack" data-toast>
            <div class="toast toast--error" role="alert" aria-live="assertive">
                <div class="toast__icon">
                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                </div>
                <div class="toast__body">
                    <p class="toast__title">Validation Error</p>
                    <p class="toast__message">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </p>
                </div>
                <button type="button" class="toast__close" aria-label="Close toast">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    @endif

<div class="register-container">
    <div class="register-card">
        {{-- Left Section: Gradient Background with Text --}}
        <div class="register-left-section">
            <div class="register-header-row">
                <h2 class="register-signup-label">Forgot Password</h2>
                <div class="register-logo">
                    <img src="/assets/hero-sec.png" alt="Anagata Executive Logo" />
                </div>
            </div>
            <div class="register-text-content">
                <p class="register-text-small">Don't worry</p>
                <h2 class="register-text-large">We'll send you a password reset link to your verified email address.</h2>
            </div>
        </div>

        {{-- Right Section: Forgot Password Form --}}
        <div class="register-right-section">
            <div class="register-form-wrapper">
                <h1 class="register-title">Forgot Password?</h1>
                <p class="register-subtitle">Enter your verified email address and we'll send you a reset link</p>

                <form method="POST" action="{{ route('password.email') }}" class="register-form">
                    @csrf

                    {{-- Email Field --}}
                    <div class="form-group">
                        <div class="form-input-wrapper">
                            <i class="form-input-icon fa-solid fa-envelope"></i>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input @error('email') is-invalid @enderror" 
                                placeholder="Email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            />
                        </div>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="register-submit-btn">
                        <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i>
                        SEND RESET LINK
                    </button>
                </form>

                {{-- Back to Login Link --}}
                <div class="register-footer">
                    <p>Remember your password? <a href="{{ route('login') }}" class="login-link">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script nonce="{{ $cspNonce ?? '' }}">
    // Toast notification initialization
    function initToast() {
        const toastStack = document.querySelector('[data-toast]');
        if (!toastStack) return;

        const toast = toastStack.querySelector('.toast');
        if (!toast) return;

        // Show with small delay for smooth entrance
        requestAnimationFrame(function () {
            toast.classList.add('toast--visible');
        });

        const autoHideMs = 5000;
        const hide = function () {
            toast.classList.add('toast--hiding');
            setTimeout(function () {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 350);
        };

        // Auto hide
        const timer = setTimeout(hide, autoHideMs);

        // Close button
        const closeBtn = toast.querySelector('.toast__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                clearTimeout(timer);
                hide();
            });
        }
    }

    // Initialize toast when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initToast();
            // Also check after a short delay for redirects
            setTimeout(function() {
                const toastStack = document.querySelector('[data-toast]');
                if (toastStack && !toastStack.querySelector('.toast--visible')) {
                    initToast();
                }
            }, 100);
        });
    } else {
        // DOM is already ready
        initToast();
        setTimeout(function() {
            const toastStack = document.querySelector('[data-toast]');
            if (toastStack && !toastStack.querySelector('.toast--visible')) {
                initToast();
            }
        }, 100);
    }

    // Also check on page show (for back/forward navigation)
    window.addEventListener('pageshow', function() {
        initToast();
    });
</script>
@endpush
@endsection


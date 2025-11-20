<footer>
    <div class="container footer-grid">
        <div class="footer-branding">
            <h3 class="footer-brand">Anagata Executive</h3>
            <p class="footer-tagline">{{ __('app.footer.tagline') }}</p>
        </div>
        <nav class="footer-links" aria-label="{{ __('app.footer.nav_label') }}">
            <a href="{{ url('/#hero') }}">{{ __('app.nav.home') }}</a>
            <a href="{{ url('/#about') }}">{{ __('app.nav.about') }}</a>
            <a href="{{ url('/#services') }}">{{ __('app.nav.services') }}</a>
            <a href="{{ url('/#why-us') }}">{{ __('app.nav.why_us') }}</a>
            <a href="{{ url('/#contact') }}">{{ __('app.nav.contact') }}</a>
        </nav>
        <div class="footer-contacts">
            <div class="footer-contact">
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                <a href="mailto:info@anagataexecutive.co.id">info@anagataexecutive.co.id</a>
            </div>
            <div class="footer-contact">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener">+62 812-3456-7890</a>
            </div>
            <div class="footer-contact">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                <span>Multimedia Nusantara University, New Media Tower Lv.11 & 12, Jl. Boulevard Raya Gading Serpong, Kec. Kelapa Dua, Kab. Tangerang, Banten 15811</span>
            </div>
        </div>
        <div class="footer-supported">
            <h3 class="footer-supported-heading">Supported by</h3>
            <div class="footer-supported-logos">
                <img src="{{ asset('assets/logo-google-ai.png') }}" alt="Google AI logo" loading="lazy">
                <img src="{{ asset('assets/logo_kemnaker.png') }}" alt="Kemnaker logo" loading="lazy">
            </div>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>&copy; {{ date('Y') }} Anagata Executive. {{ __('app.footer.rights') }}</p>
    </div>
</footer>



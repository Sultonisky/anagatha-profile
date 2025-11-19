<footer>
    <div class="container footer-grid">
        <div class="footer-branding">
            <p class="footer-brand">Anagata Executive</p>
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
            <p class="footer-contact">
                <i class="fa-solid fa-envelope"></i>
                <a href="mailto:info@anagataexecutive.co.id">info@anagataexecutive.co.id</a>
            </p>
            <p class="footer-contact">
                <i class="fa-solid fa-phone"></i>
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener">+62 812-3456-7890</a>
            </p>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>&copy; {{ date('Y') }} Anagata Executive. {{ __('app.footer.rights') }}</p>
    </div>
</footer>



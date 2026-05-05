<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('front_asset/images/logo.png') }}" class="footer-logo" alt="DISC logo" />
                <p class="footer-p">
                    Encouraging music lovers and creators globally. Become a part of uniting us all with melodies.
                </p>
            </div>
            <div class="col-md-6 mb-4 mb-md-0 text-md-end">
                <h4 class="footer-txt">Join the community</h4>
                <div class="social-icons mt-3">
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-telegram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <h4 class="footer-txt">Stay in Touch!</h4>
                <form class="newsletter-form">
                    <input type="email" class="form-input" required placeholder="Email here..." />
                    <button type="submit" class="form-btn">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-2 mt-4">
                <p class="footer-head">My account</p>
                <ul class="footer-ul">
                    <li><a href="{{ route('feeds') }}">Feed</a></li>
                    <li><a href="{{ route('artists.list') }}">Artists</a></li>
                    <li><a href="{{ route('trending') }}">Trending</a></li>
                    <li><a href="{{ route('feature') }}">Feature</a></li>
                </ul>
            </div>
            <div class="col-md-2 mt-4">
                <p class="footer-head">Resources</p>
                <ul class="footer-ul">
                    <li><a href="{{ route('most-liked') }}">Most Liked</a></li>
                    <li><a href="{{ route('subscription.index') }}">Subscription</a></li>
                    <li><a href="{{ route('start-selling') }}">Start Selling</a></li>
                    <li><a href="{{ route('explore') }}">Explore</a></li>
                </ul>
            </div>
            <div class="col-md-2 mt-4">
                <p class="footer-head">Company</p>
                <ul class="footer-ul">
                    <li><a href="{{ route('creator-tools') }}">Creator Tools</a></li>
                    <li><a href="{{ route('register') }}">Sign Up</a></li>
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid row-2">
        <div class="footer-div">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright-text mb-0">
                        &copy; 2025 Disc Music. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <p class="copyright-text mb-0">
                        <a href="{{ route('privacy-policy') }}">Privacy policy</a> |
                        <a href="{{ route('terms-condition') }}">Terms of service</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

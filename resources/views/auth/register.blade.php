<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="{{ asset('front_asset/css/style.css') }}" rel="stylesheet" />
     <!--! Toastr -->
     <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
    <title>Sign Up</title>
</head>

<body style="background-color: #000;">
    <section class="signup-1">
        <div class="container-fluid">
            <a href="/"><img src="{{ asset('front_asset/images/logo.png') }}" class="sign-logo" /></a>
        </div>
        <div class="signup-2">
            <h3 class="sign-h3">Sign Up To Start Listening</h3>

            <form action="{{ route('register') }}" method="post" id="signupForm">
                @csrf
                <div id="emailSection">
                    <label for="email">Email Address:</label><br />
                    <input type="email" id="email" name="email" required />
                    <label for="name" class="my-2">Name:</label><br />
                    <input type="name" id="name" name="name" required />
                    <br /><br />
                    <button type="button" onclick="showPasswordField()">Next</button>
                </div>

                <div id="passwordSection" style="display: none">
                    <label for="password">Password:</label><br />
                    <input type="password" id="password" name="password" required /><br /><br />
                    <label for="confirm-password">Confirm-Password:</label><br />
                    <input type="password" id="confirm-password" name="password_confirmation" required /><br /><br />
                    <button type="submit">Sign Up</button>
                </div>
            </form>

            <h3 class="or-h3">or</h3>
            <div class="social-div">
                <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="fb">
                    <img src="{{ asset('front_asset/images/signup/fb.png') }}" /> Sign Up With Facebook
                </a>
                <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                    <img src="{{ asset('front_asset/images/signup/google.png') }}" /> Sign Up With Google
                </a>
                <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="apple">
                    <img src="{{ asset('front_asset/images/signup/apple.png') }}" /> Sign Up With Apple
                </a>
            </div>

            <h3 class="pop-c">Already have an account? <a href="{{ route('login') }}"> Log in here </a></h3>
        </div>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script src="{{ asset('front_asset/js/script.js') }}"></script>

<script>
    function showPasswordField() {
        document.getElementById('emailSection').style.display = 'none';
        document.getElementById('passwordSection').style.display = 'block';
    }
</script>
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (session('error'))
        toastr.error("{{ session('error') }}")
    @endif
    @if (session('info'))
        toastr.info("{{ session('info') }}")
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif
</script>
</html>

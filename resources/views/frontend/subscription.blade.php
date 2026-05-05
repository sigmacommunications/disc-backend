@extends('layout.subscription_menu')
@section('content')
    <section class="subs-main">
        <div class="subs-1">
            <div class="container">
                <h3 class="subs1-a">
                    START FOR FREE, THEN ENJOY $1/MONTH FOR 3 MONTHS
                </h3>
                <h3 class="subs1-b">
                    Try D’angelo’s Free For 3 Days, No Credit Card Required
                </h3>
                <form>
                    <input type="email" class="email-input" placeholder="Email Here..." required />
                    <input type="submit" class="sub-btn" value="Start free trial" />
                </form>
                <h4 class="subs1-c">
                    By Entering Your Email, You Agree To Receive Marketing Emails From
                    Shopify.
                </h4>
            </div>
        </div>

        <div class="subs-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly"
                        type="button" role="tab" aria-controls="monthly" aria-selected="true">
                        PAY MONTHLY
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">
                        pay yearly (save 25%)
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">

                    <div class="pricing-div">
                        <div class="container">
                            <div class="row d-flex">
                                @foreach ($monthlyPlans as $monthlyPlan)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="pricing-div-1">
                                            <h4 class="pric1-a">
                                                {{ $monthlyPlan->name }}
                                            </h4>
                                            @if ($monthlyPlan->subtitle)
                                                <h4 class="pric1-b">
                                                    {{ $monthlyPlan->subtitle }}
                                                </h4>
                                            @endif
                                            <p class="pric1-c">
                                                {{ $monthlyPlan->description }}
                                            </p>
                                            <div class="price">
                                                <h3 class="pric1-d">
                                                    ${{ number_format($monthlyPlan->price, 2) }}
                                                </h3>
                                                <h3 class="pric1-e">
                                                    USD / {{ $monthlyPlan->duration === 'mon' ? 'Month' : 'Year' }}
                                                </h3>
                                            </div>
                                            @if ($monthlyPlan->offer_text)
                                                <div class="price-first">
                                                    <h3 class="pric1-f">
                                                        {{ $monthlyPlan->offer_text }}
                                                    </h3>
                                                </div>
                                            @endif
                                            @if ($monthlyPlan->included_title)
                                                <h4 class="pric1-g">{{ $monthlyPlan->included_title }}</h4>
                                            @endif
                                            @if ($monthlyPlan->features->count())
                                                <ul class="price-ul">
                                                    @foreach ($monthlyPlan->features as $feature)
                                                        <li>{{ $feature->feature }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @auth
                                                <div class="d-flex justify-content-center mt-3">
                                                    <button type="button" class="free-btn btn btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#subscriptionModal"
                                                        data-plan-id="{{ $monthlyPlan->id }}"
                                                        data-plan-name="{{ $monthlyPlan->name }}"
                                                        data-plan-price="{{ $monthlyPlan->price }}"
                                                        data-plan-duration="{{ $monthlyPlan->duration }}">
                                                        Try For Free
                                                    </button>
                                                </div>
                                            @endauth

                                            @guest
                                                <div class="d-flex justify-content-center mt-3">
                                                    <a href="{{ route('login') }}" class="free-btn btn btn-primary">Login</a>
                                                </div>
                                            @endguest
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                    <div class="pricing-div">
                        <div class="container">
                            <div class="row">
                                @foreach ($yearlyPlans as $yearlyPlan)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="pricing-div-1">
                                            <h4 class="pric1-a">
                                                {{ $yearlyPlan->name }}
                                            </h4>
                                            @if ($yearlyPlan->subtitle)
                                                <h4 class="pric1-b">
                                                    {{ $yearlyPlan->subtitle }}
                                                </h4>
                                            @endif
                                            <p class="pric1-c">
                                                {{ $yearlyPlan->description }}
                                            </p>
                                            <div class="price">
                                                <h3 class="pric1-d">
                                                    ${{ number_format($yearlyPlan->price, 2) }}
                                                </h3>
                                                <h3 class="pric1-e">
                                                    USD / {{ $yearlyPlan->duration === 'mon' ? 'Month' : 'Year' }}
                                                </h3>
                                            </div>
                                            @if ($yearlyPlan->offer_text)
                                                <div class="price-first">
                                                    <h3 class="pric1-f">
                                                        {{ $yearlyPlan->offer_text }}
                                                    </h3>
                                                </div>
                                            @endif
                                            @if ($yearlyPlan->included_title)
                                                <h4 class="pric1-g">{{ $yearlyPlan->included_title }}</h4>
                                            @endif
                                            @if ($yearlyPlan->features->count())
                                                <ul class="price-ul">
                                                    @foreach ($yearlyPlan->features as $feature)
                                                        <li>{{ $feature->feature }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @auth
                                                <div class="d-flex justify-content-center mt-3">
                                                    <button type="button" class="free-btn btn btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#subscriptionModal"
                                                        data-plan-id="{{ $yearlyPlan->id }}"
                                                        data-plan-name="{{ $yearlyPlan->name }}"
                                                        data-plan-price="{{ $yearlyPlan->price }}"
                                                        data-plan-duration="{{ $yearlyPlan->duration }}">
                                                        Try For Free
                                                    </button>
                                                </div>
                                            @endauth

                                            @guest
                                                <div class="d-flex justify-content-center mt-3">
                                                    <a href="{{ route('login') }}" class="free-btn btn btn-primary">Login</a>
                                                </div>
                                            @endguest
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <p class="pric1-h">Prices May Vary By Your Store Location.</p>
            <a href="#" class="compare-btn">+ Compare Plane Features</a>

            <!-- <div class="subs-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="./assets/images/subscription/icon1.png" class="online-img" />
                            <h3 class="pric1-i">Online Store</h3>
                            <p class="pric1-j">
                                easily build an online store with the world’s
                                highest-converting, one-click checkout.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <img src="./assets/images/subscription/icon2.png" class="online-img" />
                            <h3 class="pric1-i">Sales Channels</h3>
                            <p class="pric1-j">
                                expand your reach by listing your shopify catalog across top
                                social media platforms and online marketplaces.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <img src="./assets/images/subscription/icon3.png" class="online-img" />
                            <h3 class="pric1-i">Point Of Sale</h3>
                            <p class="pric1-j">
                                shopify’s pos comes with staff management, inventory tracking,
                                and more. learn about pos.
                            </p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Bootstrap Modal -->
    @auth
        <!-- Bootstrap Modal -->
        <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="subscriptionModalLabel">
                            Subscribe to <span id="modal-plan-name"></span> Plan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body bg-secondary text-white">
                        <form id="payment-form" action="{{ route('subscription.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" id="modal-plan-id" value="">

                            <!-- Display Plan Details -->
                            <div class="mb-4">
                                <h6 class="mb-2">You will be charged $<span id="modal-plan-price"></span> for the <span
                                        id="modal-plan-name-detail"></span> Plan.</h6>
                            </div>

                            <!-- Name on Card -->
                            <div class="mb-3">
                                <label for="card-holder-name" class="form-label">Name on Card</label>
                                <input type="text" name="name" id="card-holder-name" class="form-control"
                                    placeholder="John Doe" required>
                            </div>

                            <!-- Card Details -->
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Card Details</label>
                                <div id="card-element" class="form-control">
                                    <!-- Stripe.js injects the Card Element here -->
                                </div>
                                <!-- Stripe Element Error Message -->
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" id="card-button"
                                    data-secret="{{ $intent->client_secret }}">
                                    Purchase
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Optional: Modal Footer for Additional Information -->
                    <!--
                                                                                        <div class="modal-footer bg-light">
                                                                                            <small class="text-muted">By subscribing, you agree to our Terms of Service and Privacy Policy.</small>
                                                                                        </div>
                                                                                        -->

                </div>
            </div>
        </div>
    @endauth


    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            hidePostalCode: true
        });
        cardElement.mount('#card-element');
        const form = document.getElementById('payment-form');
        const cardBtn = document.getElementById('card-button');
        const cardHolderName = document.getElementById('card-holder-name');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            cardBtn.disabled = true;

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value,
                    },
                },
            });
            if (error) {
                cardBtn.disabled = false;
            } else {
                let token = document.createElement('input');
                token.setAttribute('type', 'hidden');
                token.setAttribute('name', 'token');
                token.setAttribute('value', setupIntent.payment_method);
                form.appendChild(token);
                form.submit();
            }
        });

        var subscriptionModal = document.getElementById('subscriptionModal');

        // Listen for the modal show event
        subscriptionModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal

            // Extract info from data-* attributes
            var planId = button.getAttribute('data-plan-id');
            var planName = button.getAttribute('data-plan-name');
            var planPrice = button.getAttribute('data-plan-price');
            var planDuration = button.getAttribute('data-plan-duration');

            // Update the modal's content
            document.getElementById('modal-plan-name').textContent = planName;
            document.getElementById('modal-plan-name-detail').textContent = planName;
            document.getElementById('modal-plan-price').textContent = parseFloat(planPrice).toFixed(2);
            document.getElementById('modal-plan-id').value = planId;

            // Optionally, you can handle plan duration if needed
            // Example: Display 'Per Year' or 'Per Month'
            var durationText = planDuration === 'yr' ? 'Yearly' : 'Monthly';
            // You can add this durationText to any other element if required
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        }

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection

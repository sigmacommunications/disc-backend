@extends('layout.trending_menu')
@section('title', 'Artist Detail')
@section('content')

    <section class="blogs-three">
        <section class="b3sec1">
            <div class="container">
                <h1>MASTER THE ART OF MUSIC</h1>
                <p>lorem ipsum dolor sit amet consectetur adipiscing elit aenean luctus urna ut lorem</p>
            </div>
        </section>
        <section class="b3sec2">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <div class="hello">
                            <div class="imgdiv">
                                <img src="{{ asset("storage/{$user->profile_image}") }}" alt="">
                            </div>
                            <div class="content">
                                <h2>{{ $user->name }}</h2>
                                <p>{{ $user->artist->bio }}</p>
                            </div>

                        </div>

                        <div class="latest-events">
                            <h2>Latest Events</h2>
                            @forelse ($user->artist->events as $event)
                                <div class="le">
                                    <!-- Event Image -->
                                    @if ($event->image)
                                        <img src="{{ asset("storage/{$event->image}") }}" alt="{{ $event->title }}">
                                    @endif
                                    <!-- Event Date -->
                                    <h4>
                                        <span>{{ $event->event_date->format('d') }}</span><br>
                                        {{ strtoupper($event->event_date->format('M')) }}<br>
                                        {{ strtoupper($event->event_date->format('Y')) }}
                                    </h4>

                                    <!-- Event Description -->
                                    <p>{{ Str::limit($event->promotional_details, 150, '...') }}</p>
                                </div>
                            @empty
                                <p>No events available.</p>
                            @endforelse

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tracks">
                            <h4>Music Tracks</h4>
                            <ul>
                                @forelse ($user->artist->tracks as $track)
                                    <li class="track">
                                        <a href="javascript:void(0)" onclick="playSong({{ $track->id }})">
                                            <i class="fa-solid fa-play"></i> {{ $track->title }}
                                        </a>
                                    </li>
                                @empty
                                    <p>No tracks available.</p>
                                @endforelse

                            </ul>
                            {{-- <a href="#" class="view">View All</a> --}}
                        </div>
                        <div class="flickr">
                            <h4>FLICKR</h4>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src=" {{ asset('assets/images/blog-3/le1.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src=" {{ asset('assets/images/blog-3/le2.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src=" {{ asset('assets/images/blog-3/le3.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src=" {{ asset('assets/images/blog-3/le4.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le2.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le3.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le1.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le2.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le3.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le4.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le2.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flickimg">
                                        <img src="{{ asset('assets/images/blog-3/le3.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="view">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection
@section('scripts')
    <script>
        function playSong(trackID) {

            localStorage.setItem('trackID', trackID);

            // Redirect to the player page
            window.location.href = '{{ route('start-selling') }}';

        }
    </script>

@endsection

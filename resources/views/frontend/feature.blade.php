@extends('layout.feature_menu')
@section('content')
    <section class="feature-main">
        <div class="feature-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="feature-a">Enhance Your Music Experience</h3>
                        <p class="feature-b">
                            No more research while looking for the perfect beat, dive into
                            our carefully created selection of top music streaming and arts.
                            Explore, Discover, and be Inspired. With our vast choice of
                            genres and tailored playlists, immerse yourself in a world of
                            musical possibilities and upgrade your listening experience now.
                        </p>
                        <div class="featurebtn-div">
                            @auth
                                <a href="#" class="shuffle-btn"><i class="fa-solid fa-shuffle"></i> Make My Playlist</a>
                                <a href="#" class="shuffle-btn"><i class="fa-solid fa-tower-broadcast"></i> Explore all
                                    Tracks</a>
                                <a href="#" class="shuffle-btn">Subscribe &nbsp; 10.4M</a>
                            @else
                                <a href="{{ route('login') }}" class="shuffle-btn"
                                    style="background: linear-gradient(135deg, #2c3e50 0%, #4a6741 100%); border: 1px solid #silver;"><i
                                        class="fa-solid fa-lock"></i> Login to Create Playlist</a>
                                <a href="{{ route('login') }}" class="shuffle-btn"
                                    style="background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); border: 1px solid #bdc3c7;"><i
                                        class="fa-solid fa-lock"></i> Login to Explore Tracks</a>
                                <a href="{{ route('register') }}" class="shuffle-btn"
                                    style="background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%); color: #2c3e50; border: 1px solid #ecf0f1;">Join
                                    10.4M Users</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-md-5"></div>
                </div>
            </div>
        </div>

        <div class="feature-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images/feature/feature-2.png') }}" class="feature-2-img" />
                    </div>
                    <div class="col-md-6">
                        <h3 class="feature-2a">Start Your Beatmaker Journey Today!</h3>
                        <p class="feature-2b">
                            Become a music beat maker and achieve your creative potential in
                            our thriving community of artists and music enthusiasts. Whether
                            you're a seasoned producer or just getting started, our platform
                            provides the tools, resources, and support you need to bring
                            your musical concepts to life.
                        </p>
                        <img src="{{ asset('assets/images/feature/feature-2a.png') }}" class="feature-2-imga" />
                    </div>
                </div>
            </div>
        </div>

        <div class="feature-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h3 class="feature-3a">Latest Track</h3>
                        <p class="feature-3b">
                            Discover the most recent beats and melodies in our Latest
                            Tracks.
                        </p>
                    </div>

                    @auth
                        <div class="col-md-8 mt-5 px-4">
                            <div class="feature-3-abc">
                                @foreach ($latestTracks as $track)
                                    <div class="feature-3-inner">
                                        <img src="{{ asset('storage/' . $track->cover_image_path) }}" class="feature-3img" />
                                        <div class="feature-3-innera">
                                            <h4 class="feature-3c">{{ $track->title }}</h4>
                                            <h4 class="feature-3d">{{ $track->created_at->year }}</h4>
                                        </div>
                                    </div>
                                    <div class="contain">
                                        <div class="music-player">
                                            <div class="titre">
                                                <h3>{{ $track->artist->name }}</h3>
                                                <h1>{{ $track->title }}</h1>
                                            </div>
                                            <div class="lecteur">
                                                <audio style="width: 100%" class="fc-media" controls>
                                                    <source src="{{ asset('storage/' . $track->audio_file_path) }}"
                                                        type="audio/mp3" />
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-md-flex mt-5">
                            @foreach ($latestTracks as $track)
                                <div class="feature-3-inner-123 mt-4">
                                    <img src="{{ asset('storage/' . $track->cover_image_path) }}" class="feature-3imga" />
                                    <div class="feature-3-innera">
                                        <h4 class="feature-3e">{{ $track->title }}</h4>
                                        <h4 class="feature-3f">{{ $track->created_at->year }}</h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-md-12 mt-5">
                            <div class="auth-required-section text-center p-5"
                                style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 20px; color: #ecf0f1; box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: relative; overflow: hidden;">
                                <div
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('{{ asset('assets/images/music-pattern.png') }}') repeat; opacity: 0.1; z-index: 1;">
                                </div>
                                <div style="position: relative; z-index: 2;">
                                    <div
                                        style="background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                                        <i class="fa-solid fa-lock fa-2x" style="color: #2c3e50;"></i>
                                    </div>
                                    <h3 class="mb-3"
                                        style="color: #ecf0f1; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                        Premium Latest Tracks</h3>
                                    <p class="mb-4"
                                        style="color: #bdc3c7; font-size: 16px; max-width: 600px; margin: 0 auto;">Login to
                                        access our curated selection of the newest beats and melodies from top artists worldwide
                                    </p>

                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div
                                                style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 10px; margin-bottom: 10px;">
                                                <i class="fa-solid fa-headphones-simple fa-2x mb-2" style="color: #95a5a6;"></i>
                                                <p style="color: #ecf0f1; font-size: 14px; margin: 0;">High Quality Audio</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 10px; margin-bottom: 10px;">
                                                <i class="fa-solid fa-download fa-2x mb-2" style="color: #95a5a6;"></i>
                                                <p style="color: #ecf0f1; font-size: 14px; margin: 0;">Offline Listening</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 10px; margin-bottom: 10px;">
                                                <i class="fa-solid fa-infinity fa-2x mb-2" style="color: #95a5a6;"></i>
                                                <p style="color: #ecf0f1; font-size: 14px; margin: 0;">Unlimited Skips</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="auth-buttons">
                                        <a href="{{ route('login') }}" class="btn btn-lg me-3"
                                            style="background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); color: #2c3e50; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; box-shadow: 0 5px 15px rgba(0,0,0,0.2); text-decoration: none; display: inline-block;">
                                            <i class="fa-solid fa-sign-in-alt me-2"></i> Login Now
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-lg"
                                            style="background: transparent; color: #ecf0f1; border: 2px solid #95a5a6; padding: 12px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s ease;">
                                            <i class="fa-solid fa-user-plus me-2"></i> Sign Up Free
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="feature-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="feature-4a">Embrace the Power of Music!</h3>
                        <p class="feature-4b">
                            Music is more than simply sound; it expresses the human
                            experience. It can motivate, inspire, and heal. Whether you're
                            dancing to your favorite beat or seeking comfort in a meaningful
                            tune, music has the power to touch our souls and bring us
                            together. So tune in, turn up the volume, and let the music
                            accompany you.
                        </p>
                        <div class="feature-4-inner">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('assets/images/feature/feature-4a.png') }}"
                                        class="feature-4a-img" />
                                    <img src="{{ asset('assets/images/feature/feature-4b.png') }}"
                                        class="feature-4a-img" />
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset('assets/images/feature/feature-4c.png') }}"
                                        class="feature-4a-img" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 px-3">
                        <img src="{{ asset('assets/images/feature/feature-4d.png') }}" class="feature-4a-img" />
                        <div class="feature-4-innera">
                            <img src="{{ asset('assets/images/feature/feature-4e.png') }}" class="feature-4b-img" />
                            <img src="{{ asset('assets/images/feature/feature-4f.png') }}" class="feature-4c-img" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('assets/images/feature/feature-4g.png') }}" class="feature-4d-img" />
                        <img src="{{ asset('assets/images/feature/feature-4h.png') }}" class="feature-4e-img" />
                    </div>
                </div>
            </div>
        </div>

        <div class="feature-5">
            <div class="container-fluid">
                <h3 class="feature-3a">Tune into Live Music!</h3>
                <p class="feature-5b">
                    From moderate acoustic performances to incredible concerts, our
                    selection of fascinating live videos allows you to enjoy the magic
                    of live music from the comfort of your own home.
                </p>

                @auth
                    <div class="carousel">
                        <div class="carousel__body">
                            <div class="carousel__slider">
                                @foreach ($latestTracks as $track)
                                    <div class="carousel__slider__item">
                                        <div class="item__3d-frame">
                                            <div class="item__3d-frame__box item__3d-frame__box--front">
                                                <img src="{{ asset('storage/' . $track->cover_image_path) }}"
                                                    class="feature-5-img" />
                                                <div class="music-player1">
                                                    <audio class="audio-element"
                                                        src="{{ asset('storage/' . $track->audio_file_path) }}"></audio>
                                                    <button class="start-button">
                                                        <i class="fa-solid fa-pause"></i>
                                                    </button>
                                                    <button class="stop-button">
                                                        <i class="fa-solid fa-play"></i>
                                                    </button>
                                                    <button class="reset-button">
                                                        <i class="fa-solid fa-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="auth-required-carousel text-center p-5"
                        style="background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); border-radius: 20px; position: relative; overflow: hidden; margin: 20px 0;">
                        <div
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 50% 50%, rgba(149, 165, 166, 0.1) 0%, transparent 70%); z-index: 1;">
                        </div>
                        <div style="position: relative; z-index: 2;">
                            <div
                                style="background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(0,0,0,0.3);">
                                <i class="fa-solid fa-music fa-3x" style="color: #2c3e50;"></i>
                            </div>
                            <h4 class="mb-3" style="color: #ecf0f1; font-weight: 700; font-size: 28px;">Live Music
                                Experience</h4>
                            <p style="color: #bdc3c7; font-size: 18px; max-width: 500px; margin: 0 auto 30px;">Experience the
                                thrill of live performances with our interactive 3D carousel and premium audio controls</p>

                            <div class="live-features mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 25px; border-radius: 15px; margin-bottom: 15px; border: 1px solid rgba(149, 165, 166, 0.3);">
                                            <i class="fa-solid fa-video fa-2x mb-3" style="color: #95a5a6;"></i>
                                            <p style="color: #ecf0f1; font-size: 14px; margin: 0; font-weight: 500;">Live
                                                Concerts</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 25px; border-radius: 15px; margin-bottom: 15px; border: 1px solid rgba(149, 165, 166, 0.3);">
                                            <i class="fa-solid fa-cube fa-2x mb-3" style="color: #95a5a6;"></i>
                                            <p style="color: #ecf0f1; font-size: 14px; margin: 0; font-weight: 500;">3D
                                                Interface</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 25px; border-radius: 15px; margin-bottom: 15px; border: 1px solid rgba(149, 165, 166, 0.3);">
                                            <i class="fa-solid fa-sliders fa-2x mb-3" style="color: #95a5a6;"></i>
                                            <p style="color: #ecf0f1; font-size: 14px; margin: 0; font-weight: 500;">Audio
                                                Controls</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 25px; border-radius: 15px; margin-bottom: 15px; border: 1px solid rgba(149, 165, 166, 0.3);">
                                            <i class="fa-solid fa-heart fa-2x mb-3" style="color: #95a5a6;"></i>
                                            <p style="color: #ecf0f1; font-size: 14px; margin: 0; font-weight: 500;">Save
                                                Favorites</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="auth-buttons">
                                <a href="{{ route('login') }}" class="btn btn-lg me-3"
                                    style="background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); color: #2c3e50; border: none; padding: 15px 35px; border-radius: 30px; font-weight: 700; box-shadow: 0 8px 20px rgba(0,0,0,0.3); text-decoration: none; display: inline-block; font-size: 16px;">
                                    <i class="fa-solid fa-play me-2"></i> Start Listening
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-lg"
                                    style="background: transparent; color: #ecf0f1; border: 2px solid #95a5a6; padding: 15px 35px; border-radius: 30px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 16px;">
                                    <i class="fa-solid fa-user-plus me-2"></i> Join Free
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <div class="feature-6">
            <div class="container">
                <h3 class="feature-6a">Play List</h3>
                <p class="feature-6b">
                    Check out our playlist or create a playlist of your favorite beats.
                </p>

                @auth
                    <h3 class="feature-6c">Songs</h3>
                    <div class="playlist-div">
                        @foreach ($playlist as $track)
                            <div class="playlist-inner">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="playlist-inner-a">
                                            <img src="{{ asset('storage/' . $track->cover_image_path) }}"
                                                class="playlist-img" />
                                            <h4 class="playlist-a">{{ $track->title }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="playlist-b">{{ $track->artist->name }}</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="playlist-b">{{ $track->plays_count }} Plays</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <h4 class="playlist-b">{{ optional($track->album)->title }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="#" class="showall-btn">Show all</a>
                @else
                    <div class="auth-required-playlist text-center p-5"
                        style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); border-radius: 20px; position: relative; overflow: hidden; margin: 20px 0;">
                        <div
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(45deg, transparent 49%, rgba(149, 165, 166, 0.1) 50%, transparent 51%); z-index: 1;">
                        </div>
                        <div style="position: relative; z-index: 2;">
                            <div
                                style="background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); width: 90px; height: 90px; border-radius: 50%; margin: 0 auto 25px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
                                <i class="fa-solid fa-list-music fa-2x" style="color: #2c3e50;"></i>
                            </div>
                            <h4 class="mb-3" style="color: #ecf0f1; font-weight: 700; font-size: 26px;">Your Personal
                                Playlist</h4>
                            <p style="color: #bdc3c7; font-size: 16px; max-width: 500px; margin: 0 auto 30px;">Create,
                                organize, and enjoy your favorite tracks with our advanced playlist management system</p>

                            <div class="playlist-preview mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="playlist-mock-item d-flex align-items-center p-3 mb-3"
                                            style="background: rgba(236, 240, 241, 0.1); border-radius: 15px; border: 1px solid rgba(149, 165, 166, 0.2);">
                                            <div
                                                style="width: 50px; height: 50px; background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-music" style="color: #2c3e50;"></i>
                                            </div>
                                            <div style="text-align: left;">
                                                <p style="color: #ecf0f1; margin: 0; font-size: 14px; font-weight: 600;">Track
                                                    Name</p>
                                                <p style="color: #95a5a6; margin: 0; font-size: 12px;">Artist Name</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="playlist-mock-item d-flex align-items-center p-3 mb-3"
                                            style="background: rgba(236, 240, 241, 0.1); border-radius: 15px; border: 1px solid rgba(149, 165, 166, 0.2);">
                                            <div
                                                style="width: 50px; height: 50px; background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-music" style="color: #2c3e50;"></i>
                                            </div>
                                            <div style="text-align: left;">
                                                <p style="color: #ecf0f1; margin: 0; font-size: 14px; font-weight: 600;">Track
                                                    Name</p>
                                                <p style="color: #95a5a6; margin: 0; font-size: 12px;">Artist Name</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="playlist-features mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 12px; margin-bottom: 10px; border: 1px solid rgba(149, 165, 166, 0.2);">
                                            <i class="fa-solid fa-heart fa-2x mb-2" style="color: #e74c3c;"></i>
                                            <p style="color: #ecf0f1; font-size: 13px; margin: 0; font-weight: 500;">Save
                                                Favorites</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 12px; margin-bottom: 10px; border: 1px solid rgba(149, 165, 166, 0.2);">
                                            <i class="fa-solid fa-shuffle fa-2x mb-2" style="color: #27ae60;"></i>
                                            <p style="color: #ecf0f1; font-size: 13px; margin: 0; font-weight: 500;">Smart
                                                Shuffle</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 12px; margin-bottom: 10px; border: 1px solid rgba(149, 165, 166, 0.2);">
                                            <i class="fa-solid fa-download fa-2x mb-2" style="color: #3498db;"></i>
                                            <p style="color: #ecf0f1; font-size: 13px; margin: 0; font-weight: 500;">Offline
                                                Mode</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            style="background: rgba(236, 240, 241, 0.1); padding: 20px; border-radius: 12px; margin-bottom: 10px; border: 1px solid rgba(149, 165, 166, 0.2);">
                                            <i class="fa-solid fa-share-nodes fa-2x mb-2" style="color: #9b59b6;"></i>
                                            <p style="color: #ecf0f1; font-size: 13px; margin: 0; font-weight: 500;">Share
                                                Playlists</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="auth-buttons">
                                <a href="{{ route('login') }}" class="btn btn-lg me-3"
                                    style="background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%); color: #2c3e50; border: none; padding: 15px 35px; border-radius: 30px; font-weight: 700; box-shadow: 0 8px 20px rgba(0,0,0,0.3); text-decoration: none; display: inline-block; font-size: 16px;">
                                    <i class="fa-solid fa-list-music me-2"></i> Access Playlist
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-lg"
                                    style="background: transparent; color: #ecf0f1; border: 2px solid #95a5a6; padding: 15px 35px; border-radius: 30px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 16px;">
                                    <i class="fa-solid fa-user-plus me-2"></i> Join Free
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </section>

    <style>
        /* Additional hover effects for silver/black theme */
        .auth-required-section:hover,
        .auth-required-carousel:hover,
        .auth-required-playlist:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        .auth-required-section .btn:hover,
        .auth-required-carousel .btn:hover,
        .auth-required-playlist .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .playlist-mock-item:hover {
            background: rgba(236, 240, 241, 0.2) !important;
            transition: all 0.3s ease;
        }

        .playlist-features>div>div:hover,
        .live-features>div>div:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
    </style>
@endsection

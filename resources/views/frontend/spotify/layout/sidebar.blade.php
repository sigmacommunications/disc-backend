<div class="sidebar">
    <div class="sidebar-1">
        <div class="sidebar-inner sidebar-inner-main my-0">
            <div class="playlist-add-btn">
                <h4 class="sidebar-inner-a">
                    <img src="{{ asset('assets/images/music-player/library-icon.png') }}" class="icon" />
                    Your Library
                </h4>
                <div class="dropdown playlist-add">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('playlists.index') }}">Create a new playlist</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sidebar-inner1">
                @auth
                    @php
                        $likedSongCount = App\Models\LikedSong::where('user_id', auth()->id())->count();
                    @endphp
                    @if ($likedSongCount > 0)
                        <button class="play-div my-2"
                            @if (Route::currentRouteName() == 'start-selling') onclick="loadLikedSongs()"
                      @else
                          onclick="window.location.href='{{ route('start-selling') }}'" @endif>
                            <i class="fa-solid fa-music"></i>
                            <div class="play-list">
                                <p>Liked Songs</p>
                                <h6>Playlist . {{ $likedSongCount }} Liked Songs</h6>
                            </div>
                        </button>
                    @endif

                    @forelse (auth()->user()->playlists as $playlist)
                        <a href="{{ route('playlists.show', $playlist->id) }}" id="playlist-{{ $playlist->id }}"
                            class="play-div" onclick="handleAnchorClick(event, {{ $playlist->id }})"
                            aria-labelledby="playlist-title-{{ $playlist->id }} playlist-owner-{{ $playlist->id }}">
                            <span class="icon-music" aria-hidden="true">
                                <i class="fa-solid fa-music"></i>
                            </span>
                            <div class="play-list">
                                <p id="playlist-title-{{ $playlist->id }}">{{ $playlist->name }}</p>
                                <h6 id="playlist-owner-{{ $playlist->id }}">Playlist • {{ auth()->user()->name }}</h6>
                            </div>
                            <div class="hover-playbtn">
                                <button type="button" class="play-button" aria-label="Play {{ $playlist->name }}"
                                    @if (Route::currentRouteName() == 'start-selling') onclick="playPlaylist({{ $playlist->id }})"
                      @else
                          onclick="window.location.href='{{ route('start-selling') }}'" @endif>
                                    <i class="fa-sharp fa-solid fa-play"></i>
                                </button>
                            </div>
                        </a>

                    @empty
                        <h4 class="sidebar-inner1-a">Create your first playlist</h4>
                        <p class="sidebar-inner1-b">It's easy, we'll help you</p>
                        <a href="{{ route('playlists.index') }}" class="sidebar-inner1-btn">Create playlist</a>
                    @endforelse
                @else
                    <h4 class="sidebar-inner1-a">Welcome to Music Library</h4>
                    <p class="sidebar-inner1-b">Log in to create and manage your playlists.</p>
                    <a href="{{ route('login') }}" class="sidebar-inner1-btn">Log in</a>
                @endauth

            </div>

            <div class="links-div">
                <a href="#">Legal</a>
                <a href="#">Privacy Center</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Cookies</a>
                <a href="#">About Ads</a>
                <a href="#">Accessibility</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</div>

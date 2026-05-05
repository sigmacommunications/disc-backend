@extends('frontend.spotify.layout.app')
@section('content')
    <div class="right-bar">
        <section class="musicplayer-main-sec">
            <div class="mp-sec">
                <h2 class="mp-main-head">Popular Artist</h2>
                <div class="pop-artists">
                    @foreach ($artists as $artist)
                        <div class="artist">
                            {{-- @dd($artist->user->profile_image) --}}
                            <img src="{{ asset('storage/' . $artist->user->profile_image) }}" alt="{{ $artist->user->name }}">
                            <h5 class="name">{{ $artist->name }}</h5>
                            <p class="mp-desc">Artist</p>
                            <div class="playbtndiv">
                                <a class="playbtn" href="javascript:void(0);" onclick="playArtist({{ $artist->id }})">
                                    <i class="fa-sharp fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mp-sec">
                <h2 class="mp-main-head">Popular Albums and Singers</h2>
                <div class="pop-albums">
                    @foreach ($albums as $album)
                        <div class="albums">
                            {{-- @dd($album->cover_image) --}}
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="">
                            <p class="mp-desc">{{ $album->description }}</p>
                            <div class="playbtndiv">
                                <a class="playbtn" href="javascript:void(0);" onclick="playAlbum({{ $album->id }})">
                                    <i class="fa-sharp fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mp-sec">
                <h2 class="mp-main-head">Popular Radio</h2>
                <div class="pop-albums">
                    @foreach ($tracks as $track)
                        <div class="albums">
                            <img src="{{ asset("storage/{$track->cover_image_path}") }}" alt="">
                            <p class="mp-desc">{{ $track->title }}</p>
                            <div class="playbtndiv">
                                <a class="playbtn" href="javascript:void(0);"
                                    onclick="playSingleTrack({{ $track->id }})">
                                    <i class="fa-sharp fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <footer class="feat-foot" id="footer">
            <div class="container">
                <!-- Footer content -->
                <div class="footer-div">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="copyright-text">
                                © {{ now()->year }} Mr. Bertrel Bogan. All rights reserved.
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="copyright-text">
                                Privacy policy | Terms of service
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('scripts')
    <script>
        let isPlaying = false;
        let trackIndex = 0;
        let trackList = [];
        let currTrack = new Audio();
        let updateTimer;
        let trackPlayedPercentage = 0;

        let track_art = document.querySelector(".track-arts");
        let track_arts = document.querySelector(".track-artss");
        let track_name = document.querySelectorAll(".track-name");
        let track_artist = document.querySelectorAll(".track-artist");

        let playpause_btn = document.querySelector(".playpause-track");
        let next_btn = document.querySelector(".next-track");
        let prev_btn = document.querySelector(".prev-track");

        let seek_slider = document.querySelector(".seek_slider");
        let volume_slider = document.querySelector(".volume_slider");
        let curr_time = document.querySelector(".current-time");
        let total_duration = document.querySelector(".total-duration");

        let playerClass = document.querySelector(".bottom-player");
        let sidebarClass = document.querySelector(".left-bar");
        const queueList = document.querySelector(".queue-list");


        let isSongLiked = false; // This keeps track of whether the song is liked or not

        // Function to handle the like button click
        function likeSong() {
            const likeIcon = document.getElementById('like-icon');
            const likeButton = document.getElementById('like-button');

            // Toggle the like state
            isSongLiked = !isSongLiked;

            if (isSongLiked) {
                // Change the icon to heart when liked
                likeIcon.classList.remove('fa-plus');
                likeIcon.classList.add('fa-heart');
                likeButton.setAttribute('aria-label', 'Song Liked');
                likeButton.setAttribute('title', 'You have liked this song');
                // Optionally, store the liked song information (e.g., in localStorage or send to server)
                storeLikedSong();
            } else {
                // Change the icon back to plus when not liked
                likeIcon.classList.remove('fa-heart');
                likeIcon.classList.add('fa-plus');
                likeButton.setAttribute('aria-label', 'Like Song');
                likeButton.setAttribute('title', 'Click to like this song');
                // Optionally, remove the liked song information
                removeLikedSong();
            }
        }

        function updateLikeButtonState(isLiked) {
            const likeIcon = document.getElementById('like-icon');
            const likeButton = document.getElementById('like-button');

            if (isLiked) {
                isSongLiked = true;
                likeIcon.classList.remove('fa-plus');
                likeIcon.classList.add('fa-heart');
                likeButton.setAttribute('aria-label', 'Song Liked');
                likeButton.setAttribute('title', 'You have liked this song');
            } else {
                isSongLiked = false;
                likeIcon.classList.remove('fa-heart');
                likeIcon.classList.add('fa-plus');
                likeButton.setAttribute('aria-label', 'Like Song');
                likeButton.setAttribute('title', 'Click to like this song');
            }
        }

        // Optional: Function to store the liked song (could be in localStorage or sent to a backend)
        const storeLikedSongRoute = @json(route('liked-songs.store'));
        // const storeLikedSongRoutes =  @json(route('liked-songs.store')) ;
        const removeLikedSongRoute = @json(route('liked-songs.remove'));
        const csrfToken = @json(csrf_token());

        function storeLikedSong() {
            const trackId = currTrack.trackId; // Only send track ID

            $.ajax({
                url: storeLikedSongRoute,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // Include CSRF token
                },
                data: {
                    trackId
                },
                success: function(response) {
                    console.log('Song liked and stored in the database!', trackId);
                    toastr.success('Song added to your liked songs!');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to store the liked song:', xhr.responseText);
                },
            });
        }

        function removeLikedSong() {
            const trackId = currTrack.trackId; // Only send track ID

            $.ajax({
                url: removeLikedSongRoute,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // Include CSRF token
                },
                data: {
                    trackId
                },
                success: function(response) {
                    toastr.success('Song removed to your liked songs!');
                    console.log('Song unliked and removed from the database!', trackId);
                },
                error: function(xhr, status, error) {
                    console.error('Failed to remove the liked song:', xhr.responseText);
                },
            });
        }

        function loadTrack(index) {
            const track = trackList[index];
            console.log(track);


            if (playerClass) {
                playerClass.classList.remove("d-none");
            }
            if (sidebarClass) {
                sidebarClass.classList.remove("d-none");
            }
            track_art.style.backgroundImage = "url(storage/" + track.cover_image_path + ")";
            track_arts.src = "storage/" + track.cover_image_path;
            currTrack.src = "storage/" + track.audio_file_path;
            currTrack.trackId = track.id;
            track_name.forEach((element) => {
                element.textContent = track.title;
            });


            track_artist.forEach((element) => {
                element.textContent = track.artist.user.name;
            });
            document.getElementById('sellingMainSection').classList.add('after-login');

            console.log(track_name, track_artist);

            updateQueue();
            clearInterval(updateTimer);
            resetValues();
            currTrack.load();
            updateLikeButtonState(track.is_liked);

            updateTimer = setInterval(seekUpdate, 1000);
            currTrack.addEventListener("ended", function() {
                if (currentRepeatMode === RepeatMode.ONE) {
                    loadTrack(trackIndex);
                    playTrack();
                } else {
                    nextTrack();
                }
            });


            console.log('done');
            playpauseTrack();
            trackPlayedPercentage = 0;
        }

        function updateQueue() {
            // Clear existing queue
            queueList.innerHTML = '';

            // Populate queue list
            trackList.forEach((track, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between',
                    'align-items-center');

                // Track Info
                const trackInfo = document.createElement('div');
                trackInfo.innerHTML = `<strong>${track.title}</strong> by ${track.artist.user.name}`;

                // Play Button for Queue Item
                const playBtn = document.createElement('button');
                playBtn.classList.add('btn', 'btn-sm', 'btn-outline-primary');
                playBtn.innerHTML = '<i class="fa fa-play"></i>';
                playBtn.onclick = () => {
                    trackIndex = index;
                    loadTrack(trackIndex);
                };

                // Remove Button for Queue Item
                const removeBtn = document.createElement('button');
                removeBtn.classList.add('btn', 'btn-sm', 'btn-outline-danger', 'ms-2');
                removeBtn.innerHTML = '<i class="fa fa-times"></i>';
                removeBtn.onclick = () => {
                    trackList.splice(index, 1);
                    updateQueue();
                    if (index === trackIndex) {
                        pauseTrack();
                        if (trackList.length > 0) {
                            loadTrack(0);
                        } else {
                            // Hide player and sidebar if queue is empty
                            playerClass.classList.add("d-none");
                            sidebarClass.classList.add("d-none");
                            document.getElementById('sellingMainSection').classList.remove('after-login');
                        }
                    } else if (index < trackIndex) {
                        trackIndex--;
                    }
                };

                // Append Elements to List Item
                listItem.appendChild(trackInfo);
                listItem.appendChild(playBtn);
                listItem.appendChild(removeBtn);

                // Append List Item to Queue List
                queueList.appendChild(listItem);
            });
        }

        function resetValues() {
            curr_time.textContent = "00:00";
            total_duration.textContent = "00:00";
            seek_slider.value = 0;
        }


        function playpauseTrack() {
            if (!isPlaying) playTrack();
            else pauseTrack();
        }


        function playTrack() {
            currTrack.play();
            isPlaying = true;
            playpause_btn.innerHTML = '<i class="fa fa-pause-circle fa-5x"></i>';
        }


        function pauseTrack() {
            currTrack.pause();
            isPlaying = false;
            playpause_btn.innerHTML = '<i class="fa fa-play-circle fa-5x"></i>';
        }


        // function nextTrack() {
        //     if (trackIndex < trackList.length - 1) trackIndex++;
        //     else trackIndex = 0;
        //     loadTrack(trackIndex);
        //     playTrack();
        // }
        const RepeatMode = {
            NONE: 0,
            ALL: 1,
            ONE: 2
        };

        // Initialize current repeat mode
        let currentRepeatMode = RepeatMode.NONE;

        // Get DOM elements
        const repeatIcon = document.getElementById('repeat-icon');
        const repeatOneIndicator = document.getElementById('repeat-one-indicator');
        const repeatTrackDiv = document.querySelector('.repeat-track');

        // Function to cycle through repeat modes
        function cycleRepeatMode() {
            // Cycle to the next mode
            currentRepeatMode = (currentRepeatMode + 1) % 3;

            // Update the UI based on the current mode
            switch (currentRepeatMode) {
                case RepeatMode.NONE:
                    // No Repeat
                    repeatTrackDiv.classList.remove('active', 'repeat-one');
                    repeatIcon.style.color = '#fff'; // Default color
                    repeatIcon.title = 'No Repeat';
                    repeatOneIndicator.style.display = 'none';
                    break;
                case RepeatMode.ALL:
                    // Repeat All
                    repeatTrackDiv.classList.add('active');
                    repeatTrackDiv.classList.remove('repeat-one');
                    repeatIcon.style.color = '#1DB954'; // Active color
                    repeatIcon.title = 'Repeat All';
                    repeatOneIndicator.style.display = 'none';
                    break;
                case RepeatMode.ONE:
                    // Repeat One
                    repeatTrackDiv.classList.add('active', 'repeat-one');
                    repeatIcon.style.color = '#1DB954'; // Active color
                    repeatIcon.title = 'Repeat One';
                    repeatOneIndicator.style.display = 'flex';
                    break;
            }

            // Save the current repeat mode to localStorage
            saveRepeatMode();
        }

        // Function to save repeat mode to localStorage
        function saveRepeatMode() {
            localStorage.setItem('currentRepeatMode', currentRepeatMode);
        }

        // Function to load repeat mode from localStorage
        function loadRepeatMode() {
            const savedMode = localStorage.getItem('currentRepeatMode');
            if (savedMode !== null) {
                currentRepeatMode = parseInt(savedMode);
                updateRepeatUI();
            }
        }

        // Function to update the Repeat button UI based on currentRepeatMode
        function updateRepeatUI() {
            switch (currentRepeatMode) {
                case RepeatMode.NONE:
                    // No Repeat
                    repeatTrackDiv.classList.remove('active', 'repeat-one');
                    repeatIcon.style.color = '#fff'; // Default color
                    repeatIcon.title = 'No Repeat';
                    repeatOneIndicator.style.display = 'none';
                    break;
                case RepeatMode.ALL:
                    // Repeat All
                    repeatTrackDiv.classList.add('active');
                    repeatTrackDiv.classList.remove('repeat-one');
                    repeatIcon.style.color = '#1DB954'; // Active color
                    repeatIcon.title = 'Repeat All';
                    repeatOneIndicator.style.display = 'none';
                    break;
                case RepeatMode.ONE:
                    // Repeat One
                    repeatTrackDiv.classList.add('active', 'repeat-one');
                    repeatIcon.style.color = '#1DB954'; // Active color
                    repeatIcon.title = 'Repeat One';
                    repeatOneIndicator.style.display = 'flex';
                    break;
            }
        }

        // Load the repeat mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadRepeatMode();
            updateRepeatUI();

            // Initialize Bootstrap tooltips if using them
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            const storedTrackID = localStorage.getItem('trackID');

            if (storedTrackID !== null) {
                trackID = parseInt(storedTrackID);

                playSingleTrack(trackID);
            }


            localStorage.removeItem('trackID');
        });

        // Modify nextTrack function to handle repeat modes
        function nextTrack() {
            if (currentRepeatMode === RepeatMode.ONE) {
                // Repeat the current track
                loadTrack(trackIndex);
                playTrack();
            } else if (trackIndex < trackList.length - 1) {
                trackIndex++;
                loadTrack(trackIndex);
                playTrack();
            } else {
                if (currentRepeatMode === RepeatMode.ALL) {
                    trackIndex = 0;
                    loadTrack(trackIndex);
                    playTrack();
                } else {
                    // No repeat, stop playing
                    pauseTrack();
                    // Optionally, hide the player or show a notification
                }
            }
        }


        function prevTrack() {
            if (trackIndex > 0) trackIndex--;
            else trackIndex = trackList.length - 1;
            loadTrack(trackIndex);
            playTrack();
        }


        function repeatTrack() {
            loadTrack(trackIndex);
            playTrack();
        }


        function seekTo() {
            let seekto = currTrack.duration * (seek_slider.value / 100);
            console.log(currTrack.duration, seek_slider.value, seekto);

            currTrack.currentTime = seekto;
        }


        function setVolume() {
            currTrack.volume = volume_slider.value / 100;
        }


        function seekUpdate() {
            let seekPosition = 0;

            if (!isNaN(currTrack.duration)) {
                seekPosition = currTrack.currentTime * (100 / currTrack.duration);
                seek_slider.value = seekPosition;

                let currentMinutes = Math.floor(currTrack.currentTime / 60);
                let currentSeconds = Math.floor(currTrack.currentTime - currentMinutes * 60);
                let durationMinutes = Math.floor(currTrack.duration / 60);
                let durationSeconds = Math.floor(currTrack.duration - durationMinutes * 60);

                if (currentSeconds < 10) currentSeconds = "0" + currentSeconds;
                if (durationSeconds < 10) durationSeconds = "0" + durationSeconds;
                if (currentMinutes < 10) currentMinutes = "0" + currentMinutes;
                if (durationMinutes < 10) durationMinutes = "0" + durationMinutes;

                curr_time.textContent = currentMinutes + ":" + currentSeconds;
                total_duration.textContent = durationMinutes + ":" + durationSeconds;




                if (seekPosition >= 5 && trackPlayedPercentage < 25) {
                    trackPlayedPercentage = 25;
                    trackPlayToDatabase(currTrack.trackId);
                }
            }
        }
        // Function to handle redirection when 401 error is encountered
        function handleUnauthorized(xhr) {
            if (xhr.status === 401) {
                // You can redirect to a login route here
                window.location.href = '{{ route('login') }}'; // Assuming 'login' is the name of your login route
            } else {
                console.error('Error:', xhr.statusText);
            }
        }

        // Function to track play and handle errors
        function trackPlayToDatabase(trackId) {
            $.ajax({
                url: '/track/' + trackId + '/play',
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log('Play registered in database.');
                },
                error: function(xhr) {
                    handleUnauthorized(xhr);
                    console.error('Error logging track play:', xhr.statusText);
                }
            });
        }

        function handleAnchorClick(event, playlistId) {
            // If the play button was clicked, prevent the anchor navigation
            if (event.target.closest('.play-button')) {
                event.preventDefault(); // This prevents the anchor navigation
            }
        }
        // Function to play a playlist
        function playPlaylist(playlistId) {
            $.ajax({
                url: '{{ route('playlist.tracks', ['playlistId' => '__playlistId__']) }}'.replace(
                    '__playlistId__',
                    playlistId),
                method: 'GET',
                success: function(response) {
                    trackList = response.tracks;
                    trackIndex = 0;
                    loadTrack(trackIndex);
                    playTrack();
                },
                error: function(xhr) {
                    handleUnauthorized(xhr);
                    console.error('Error fetching playlist tracks:', xhr.statusText);
                }
            });
        }

        // Function to play an album
        function playAlbum(albumId) {
            $.ajax({
                url: '{{ route('album.tracks', ['albumId' => '__albumId__']) }}'.replace('__albumId__',
                    albumId),
                method: 'GET',
                success: function(response) {
                    trackList = response.tracks;
                    trackIndex = 0;
                    loadTrack(trackIndex);
                    playTrack();
                },
                error: function(xhr) {
                    handleUnauthorized(xhr);
                    console.error('Error fetching album tracks:', xhr.statusText);
                }
            });
        }

        // Function to play artist tracks
        function playArtist(artistId) {
            $.ajax({
                url: '{{ route('artist.tracks', ['artistId' => '__artistId__']) }}'.replace('__artistId__',
                    artistId),
                method: 'GET',
                success: function(response) {
                    trackList = response.tracks;
                    trackIndex = 0;
                    loadTrack(trackIndex);
                    playTrack();
                },
                error: function(xhr) {
                    handleUnauthorized(xhr);
                    console.error('Error fetching artist tracks:', xhr.statusText);
                }
            });
        }

        // Function to play a single track
        function playSingleTrack(trackId) {

            $.ajax({
                url: '{{ route('track.play', ['trackId' => '__trackId__']) }}'.replace('__trackId__', trackId),
                method: 'GET',
                success: function(response) {
                    trackList = [response.track];
                    console.log(response);
                    trackIndex = 0;
                    loadTrack(trackIndex);
                    playTrack();
                },
                error: function(xhr) {
                    handleUnauthorized(xhr);
                    console.error('Error fetching single track:', xhr.statusText);
                }
            });
        }

        function loadLikedSongs() {
            // Fetch liked songs from the backend
            $.ajax({
                url: '{{ route('liked-songs.index') }}', // Backend route for liked songs
                method: 'GET',
                success: function(response) {
                    trackList = response.tracks; // Update trackList with liked songs
                    console.log(response);
                    trackIndex = 0; // Reset track index
                    loadTrack(trackIndex); // Load the first liked song
                    updateQueue(); // Update the queue with liked songs
                },
                error: function(xhr) {
                    console.error('Error fetching liked songs:', xhr.statusText);
                }
            });
        }
    </script>
@endsection

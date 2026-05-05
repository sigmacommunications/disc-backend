<style>
    /* resources/css/app.css */

    /* Repeat Button Styling */
    .repeat-track {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .repeat-one-indicator {
        position: absolute;
        top: -8px;
        right: -10px;
        background-color: #1DB954;
        /* Disc Green */
        color: #fff;
        border-radius: 50%;
        font-size: 10px;
        width: 16px;
        height: 16px;
        display: none;
        /* Hidden by default */
        justify-content: center;
        align-items: center;
        text-align: center;
        pointer-events: none;
        /* Prevent click events on the indicator */
    }

    /* Show the Repeat One Indicator when active */
    .repeat-track.repeat-one .repeat-one-indicator {
        display: flex;
    }

    /* Change color of repeat icon when active */
    .repeat-track.active i {
        color: #1DB954;
        /* Active color */
        transition: color 0.3s ease;
    }

    /* Smooth transition for the repeat icon color */
    .repeat-track i {
        transition: color 0.3s ease;
    }

    /* Optional: Hover effect for all buttons */
    .buttons div:hover {
        opacity: 0.8;
    }

    /* Optional: Animation for active repeat mode */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .repeat-track.active i {
        animation: pulse 0.3s;
    }
</style>
<section class="bottom-player d-none">
    <div class="player-spot">
        <div class="wrapper">
            <div class="details">
                <div class="track-art track-arts"></div>
                <div class="music-details">
                    <div class="track-name">Track Name</div>
                    <div class="track-artist">Track Artist</div>
                </div>
            </div>

            <div class="controls-main">
                <div class="buttons">
                    <!-- Player Code: Update Repeat Button with Color Indication -->
                    <div class="repeat-track" onclick="cycleRepeatMode()" tabindex="0" aria-label="Repeat">
                        <i class="fa fa-repeat" id="repeat-icon" title="No Repeat"></i>
                        <span id="repeat-one-indicator" class="repeat-one-indicator">1</span>
                    </div>

                    <div class="prev-track" onclick="prevTrack()">
                        <i class="fa-solid fa-backward"></i>
                    </div>
                    <div class="playpause-track" onclick="playpauseTrack()">
                        <i class="fa fa-play-circle"></i>
                    </div>
                    <div class="next-track" onclick="nextTrack()">
                        <i class="fa-solid fa-forward"></i>
                    </div>
                    <div class="repeat-track" onclick="likeSong()" id="like-button" tabindex="0"
                        aria-label="Like Song">
                        <i class="fa-solid fa-plus" id="like-icon"></i>
                    </div>
                </div>

                <div class="slider_container">
                    <div class="current-time">0:00</div>
                    <input type="range" min="1" max="100" value="0" class="seek_slider"
                        onchange="seekTo()">
                    <div class="total-duration">00:00</div>
                </div>
            </div>

            <div class="slider_container">
                <i class="fa-solid fa-volume-off"></i>
                <input type="range" min="1" max="100" value="99" class="volume_slider"
                    onchange="setVolume()">
                <i class="fa-solid fa-volume-high"></i>
            </div>
        </div>
    </div>
</section>
{{--
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


        clearInterval(updateTimer);
        resetValues();
        currTrack.load();


        updateTimer = setInterval(seekUpdate, 1000);
        currTrack.addEventListener("ended", nextTrack);


        console.log('done');
        playpauseTrack();
        trackPlayedPercentage = 0;
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


    function nextTrack() {
        if (trackIndex < trackList.length - 1) trackIndex++;
        else trackIndex = 0;
        loadTrack(trackIndex);
        playTrack();
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
            method: 'POST',
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

    // Function to play a playlist
    function playPlaylist(playlistId) {
        $.ajax({
            url: '{{ route('playlist.tracks', ['playlistId' => '__playlistId__']) }}'.replace('__playlistId__',
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
            url: '{{ route('album.tracks', ['albumId' => '__albumId__']) }}'.replace('__albumId__', albumId),
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
            url: '{{ route('track.show', ['trackId' => '__trackId__']) }}'.replace('__trackId__', trackId),
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
</script> --}}

// Open the full screen search box
function openSearch() {
    document.getElementById("myOverlay").style.display = "block";
}

// Close the full screen search box
function closeSearch() {
    document.getElementById("myOverlay").style.display = "none";
}

//Music Player
const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const PLAYER_STORAGE_KEY = "Music_Player_D2D";

const player = $(".c-player");
const cd = $(".c-player__cd");
// const cdThumb = $(".c-player__cd-thumb");
const playBtn = $(".btn-toggle-play");
const nextBtn = $(".btn-next");
const prevBtn = $(".btn-prev");
const randomBtn = $(".btn-random");
const repeatBtn = $(".btn-repeat");
const progress = $(".c-player__progress-bar");
const audio = $("#js-player-audio");
const playList = $(".c-player__playlist");

const app = {
    currentIndex: 0,
    indexArray: [],
    indexSum: 0,
    isPlaying: false,
    isRandom: false,
    isRepeat: false,

    songs: [
        {
            index: 1,
            name: "Walk Away From The Dark",
            singer: "Amon The Sign",
            duration: "4:01",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/walk-away-from-the-dark.mp3"
        },
        {
            index: 2,
            name: "Under The Shadows",
            singer: "Amon The Sign",
            duration: "5:10",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/under-the-shadows.mp3"
        },
        {
            index: 3,
            name: "I Believe In You",
            singer: "Amon The Sign",
            duration: "4:22",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/i-believe-in-you.mp3"
        },
        {
            index: 4,
            name: "Waiting Into Darkness",
            singer: "Amon The Sign",
            duration: "443",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/waiting-into-darkness.mp3"
        },
        {
            index: 5,
            name: "In The Room",
            singer: "Amon The Sign",
            duration: "5:04",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/in-the-room.mp3"
        },
        {
            index: 6,
            name: "Spilled Blood",
            singer: "Amon The Sign",
            duration: "5:33",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path:
                "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/spilled-blood.mp3"
        },
        {
            index: 7,
            name: "The Hunger",
            singer: "Amon The Sign",
            duration: "5:16",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/the-hunger.mp3"
        },
        {
            index: 8,
            name: "Heartbeat",
            singer: "Amon The Sign",
            duration: "5:02",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/heartbeat.mp3"
        },
        {
            index: 9,
            name: "They Won't Destroy Me",
            singer: "Amon The Sign",
            duration: "5:19",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/they-wont-destroy-me.mp3"
        },
        {
            index: 10,
            name: "Without Words, Without Tears",
            singer: "Amon The Sign",
            duration: "5:08",
            image: "https://f4.bcbits.com/img/a0568269163_16.jpg",
            path: "https://hugo-salazar.com/wp-content/themes/hugosalazar/assets/music/AmonTheSign/without-words-without-tears.mp3"
        }
    ],

    defineProperties: function () {
        Object.defineProperty(this, "currentSong", {
            get: function () {
                return this.songs[this.currentIndex];
            }
        });
    },

    renderSongs: function () {
        let htmls = this.songs.map((song, index) => {
            return `
                <div class="c-player__song" data-index=${index}>
                    <div class="c-player__song-number">${song.index}</div>
                    <div class="c-player__song-infos">
                        <h3 class="c-player__song-title">${song.name}</h3>
                        <p class="c-player__song-author">${song.singer}</p>
                    </div>
                    <div class="c-player__song-duration">${song.duration}</div>
                </div>
            `;
        });
        playList.innerHTML = htmls.join("");
    },

    handleEvents: function () {
        const _this = this;

        playBtn.onclick = function () {
            if (_this.isPlaying) {
                audio.pause();
            } else {
                _this.loadCurrentSong();
                audio.play();
            }
        };

        audio.onplay = function () {
            _this.isPlaying = true;
            player.classList.add("playing");
            // cdRotate.play();
        };
        audio.onpause = function () {
            _this.isPlaying = false;
            player.classList.remove("playing");
            // cdRotate.pause();
        };

        audio.ontimeupdate = function () {
            if (audio.currentTime) {
                progress.value = (audio.currentTime / audio.duration) * 100;
            }
        };

        progress.onchange = function () {
            audio.currentTime = (progress.value * audio.duration) / 100;
        };

        // const cdRotate = cdThumb.animate([{ transform: "rotate(360deg)" }], {
        //     duration: 10000,
        //     iterations: Infinity
        // });
        // cdRotate.pause();

        nextBtn.onclick = function () {
            let songList = Array.prototype.slice.call($$(".c-player__song"));
            let oldIndex = _this.currentIndex;
            let oldItemSong = songList.find(function (value) {
                return value.dataset.index == oldIndex;
            });
            oldItemSong.classList.remove("active");
            if (_this.isRandom) {
                _this.playRandomSong();
            } else {
                _this.currentIndex++;
                if (_this.currentIndex >= _this.songs.length) {
                    _this.currentIndex = 0;
                }
            }
            _this.loadCurrentSong();
            audio.play();
        };

        prevBtn.onclick = function () {
            let songList = Array.prototype.slice.call($$(".c-player__song"));
            let oldIndex = _this.currentIndex;
            let oldItemSong = songList.find(function (value) {
                return value.dataset.index == oldIndex;
            });
            oldItemSong.classList.remove("active");
            if (_this.isRandom) {
                _this.playRandomSong();
            } else {
                _this.currentIndex--;
                if (_this.currentIndex < 0) {
                    _this.currentIndex = _this.songs.length - 1;
                }
            }
            _this.loadCurrentSong();
            audio.play();
        };

        // randomBtn.onclick = function () {
        //     _this.isRandom = !_this.isRandom;
        //     randomBtn.classList.toggle("active", _this.isRandom);
        // };

        audio.onended = function () {
            if (_this.isRepeat) {
                audio.play();
            } else {
                nextBtn.click();
            }
        };

        // repeatBtn.onclick = function () {
        //     _this.isRepeat = !_this.isRepeat;
        //     repeatBtn.classList.toggle("active", _this.isRepeat);
        // };

        playList.onclick = function (e) {
            let songNode = e.target.closest(".c-player__song:not(.active)");
            let optionNode = e.target.closest(".c-player__song-duration");
            let oldIndex = _this.currentIndex;
            let songList = Array.prototype.slice.call($$(".c-player__song"));
            let oldItemSong = songList.find(function (value) {
                return value.dataset.index == oldIndex;
            });
            if (songNode || optionNode) {
                if (songNode && !optionNode) {
                    oldItemSong.classList.remove("active");
                    _this.currentIndex = songNode.dataset.index;
                    _this.loadCurrentSong();
                    audio.play();
                }
                if (optionNode) {
                    console.log(optionNode);
                }
            }
        };
    },

    loadCurrentSong: function () {
        let playingNow = document.querySelector("#js-playing-now h2");
        let durationSong = document.querySelector('#js-duration-song');

        playingNow.innerText = this.currentSong.index + '. ' + this.currentSong.name;
        durationSong.innerText = this.currentSong.duration;
        audio.src = this.currentSong.path;

        let songList = Array.prototype.slice.call($$(".c-player__song"));
        let itemSong = songList.find((value) => {
            return value.dataset.index == this.currentIndex;
        });
        if (itemSong) {
            itemSong.classList.add("active");
        }

        // setTimeout(() => {
        //     let songActive = $(".c-player__song.active");
        //     if (songActive) {
        //         songActive.scrollIntoView({
        //             behavior: "smooth",
        //             block: "end"
        //         });
        //     }
        // }, 200);
    },

    start: function () {
        this.defineProperties();
        this.handleEvents();
        this.loadCurrentSong();
        this.renderSongs();
    }
};

app.start();

//Music Player


jQuery('.your-class').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: '<i class="fa-solid fa-arrow-left"></i>',
    nextArrow: '<i class="fa-solid fa-arrow-right"></i>',
    autoplay: true,
});

document.addEventListener('DOMContentLoaded', function () {
    var elms = document.getElementsByClassName('splide');

    for (var i = 0; i < elms.length; i++) {
        new Splide(elms[i], {
            type: 'loop',
            drag: 'free',
            focus: 'center',
            perPage: 5,
            autoScroll: {
                speed: 0.5,
                pauseOnHover: false,
                pauseOnFocus: false,
            },
        }).mount(window.splide.Extensions);
    }
});

var audio1 = document.getElementById("audio_5f51b38");
function toggleAudio(action) {
    if (action === 'play') {
        audio1.play();
        document.getElementById("lbl-btn-play").classList.add("active");
        document.getElementById("lbl-btn-pause").classList.remove("active");
        document.getElementById("lbl-btn-play-1").classList.add("active");
        document.getElementById("lbl-btn-pause-1").classList.remove("active");
        document.getElementById("lbl-btn-play-2").classList.add("active");
        document.getElementById("lbl-btn-pause-2").classList.remove("active");
        document.getElementById("lbl-btn-play-3").classList.add("active");
        document.getElementById("lbl-btn-pause-3").classList.remove("active");
        document.getElementById("lbl-btn-play-4").classList.add("active");
        document.getElementById("lbl-btn-pause-4").classList.remove("active");
        document.getElementById("lbl-btn-play-5").classList.add("active");
        document.getElementById("lbl-btn-pause-5").classList.remove("active");
    } else if (action === 'pause') {
        audio1.pause();
        document.getElementById("lbl-btn-pause").classList.add("active");
        document.getElementById("lbl-btn-play").classList.remove("active");
        document.getElementById("lbl-btn-pause-1").classList.add("active");
        document.getElementById("lbl-btn-play-1").classList.remove("active");
        document.getElementById("lbl-btn-pause-2").classList.add("active");
        document.getElementById("lbl-btn-play-2").classList.remove("active");
        document.getElementById("lbl-btn-pause-3").classList.add("active");
        document.getElementById("lbl-btn-play-3").classList.remove("active");
        document.getElementById("lbl-btn-pause-4").classList.add("active");
        document.getElementById("lbl-btn-play-4").classList.remove("active");
        document.getElementById("lbl-btn-pause-5").classList.add("active");
        document.getElementById("lbl-btn-play-5").classList.remove("active");
    }
}

jQuery(document).ready(function () {
    // Add hover effect on .tg_background_list_column hover
    jQuery('.tg_background_list_column').hover(
        function () {
            // Remove the hover class from all .tg_background_img elements
            jQuery('.tg_background_img').removeClass('hover');
            // Find the corresponding figure and add the hover class
            jQuery(this).next('.tg_background_img').addClass('hover');
        }
    );
});

function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

window.addEventListener('load', function () {
    setTimeout(function () {
        document.getElementById('popup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }, 5000); // 5000 milliseconds = 5 seconds
});

document.getElementById('closePopup').addEventListener('click', function () {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
});

function showPasswordField() {
    document.getElementById("emailSection").style.display = "none";
    document.getElementById("passwordSection").style.display = "block";
}
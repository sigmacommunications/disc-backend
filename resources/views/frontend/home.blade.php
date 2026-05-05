@extends('layouts.app')
@section('content')
<style>
    body {
        background: url(front_asset/images/header.png) no-repeat;
        background-size: cover;
        background-position: 100% 93%;
    }
</style>
    <section class="bg1">
        <div class="container">
            <div class="bg1-inner">
                <h2 class="bg1a">Momentum</h2>
                <p class="bg1b">
                    Dynamic music ecosystem to empower musicians and artists at every stage of their stage.
                </p>
            </div>
            <div class="c-player">
                <div class="c-player__current-song">
                    <div class="c-player__cd">
                        <img src="{{ asset('front_asset/images/music.jpg') }}" class="music-thumb" />
                    </div>

                    <div id="js-playing-now" class="c-player__playing-now">
                        <h2>Amon The Sign</h2>
                    </div>

                    <div class="c-player__controls">
                        <div class="c-player__button btn-prev">
                            <i class="fa-solid fa-backward"></i>
                        </div>
                        <div class="c-player__button btn-toggle-play">
                            <i class="fas fa-pause icon-pause"></i>
                            <i class="fas fa-play icon-play"></i>
                        </div>
                        <div class="c-player__button btn-next">
                            <i class="fa-solid fa-forward"></i>
                        </div>
                    </div>

                    <div class="c-player__progress">
                        <div class="c-player__progress-start-time">0:00</div>
                        <input class="c-player__progress-bar" type="range" value="0" step="0.00001" min="0"
                            max="100" />
                        <div id="js-duration-song" class="c-player__progress-end-time">
                            4:05
                        </div>
                    </div>

                    <audio id="js-player-audio" class="c-player__audio" src="#"></audio>
                </div>

                <div class="c-player__playlist">
                    <div class="c-player__song">
                        <div class="c-player__song-number">1</div>
                        <div class="c-player__song-infos">
                            <h3 class="c-player__song-title">Music name</h3>
                            <p class="c-player__song-author">Singer</p>
                        </div>
                        <div class="c-player__song-duration">Song Duration</div>
                    </div>
                </div>
            </div>

            <h2 class="bgb">What’s Trending Right Now:</h2>
            <h3 class="bgc">Gunna</h3>
            <h3 class="bgc">Future Type Beat</h3>
            <h3 class="bgc">Drake</h3>
        </div>
    </section>
    <section class="bg2">
        <div class="container">
            <div class="your-class">
                <div>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <h3 class="bg2-a">The Best Music And Arts</h3>
                            <p class="bg2-b">
                                Take a look at our huge selection of music albums and songs
                                that you can buy or stream. Also, if you want unlimited access
                                to your favorite music beats, check out our subscription-based
                                package. It's never been easier to enjoy amazing music with
                                hassle-free purchasing and smooth streaming.
                            </p>
                            <a href="{{ route('login') }}" class="listen">LISTEN NOW</a>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('front_asset/images/bg-inner.png') }}" class="bg2-inner" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <h3 class="bg2-a">Artist Partnership</h3>
                            <p class="bg2-b">
                                Have you ever wanted to access the fabulous music maker beats
                                or make connections with other talented artists? Members of
                                our active community may collaborate and express their
                                creativity by uploading their content to our site.
                            </p>
                            <a href="{{ route('register') }}" class="listen">Collaborate Now!</a>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('front_asset/images/bg-inner.png') }}" class="bg2-inner" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg3">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="bg3-a">Storefront</h3>
                    <p class="bg3-b">
                        Reach a huge crowd with our diverse storefront, become a star
                        yourself or listen to your favorite artists.
                    </p>
                </div>
                <div class="col-md-12">
                    <section class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <li class="splide__slide">
                                    <img src="{{ asset('front_asset/images/artist1.png') }}" class="track-1" />
                                    <div class="splide-inner">
                                        <div class="social-inner">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                        </div>
                                        <h3 class="bg3-c">NEW SINGLE</h3>
                                        <p class="bg3-d">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In dui nisl, luctus non condimentum non, ullamcorper vel
                                            nulla. Pellentesque libero risus, tincidunt sit amet dapib.
                                        </p>
                                    </div>
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('front_asset/images/artist2.png') }}" class="track-1" />
                                    <div class="splide-inner">
                                        <div class="social-inner">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                        </div>
                                        <h3 class="bg3-c">NEW SINGLE</h3>
                                        <p class="bg3-d">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In dui nisl, luctus non condimentum non, ullamcorper vel
                                            nulla. Pellentesque libero risus, tincidunt sit amet dapib.
                                        </p>
                                    </div>
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('front_asset/images/artist3.png') }}" class="track-1" />
                                    <div class="splide-inner">
                                        <div class="social-inner">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                        </div>
                                        <h3 class="bg3-c">NEW SINGLE</h3>
                                        <p class="bg3-d">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In dui nisl, luctus non condimentum non, ullamcorper vel
                                            nulla. Pellentesque libero risus, tincidunt sit amet dapib.
                                        </p>
                                    </div>
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('front_asset/images/artist4.png') }}" class="track-1" />
                                    <div class="splide-inner">
                                        <div class="social-inner">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                        </div>
                                        <h3 class="bg3-c">NEW SINGLE</h3>
                                        <p class="bg3-d">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In dui nisl, luctus non condimentum non, ullamcorper vel
                                            nulla. Pellentesque libero risus, tincidunt sit amet dapib.
                                        </p>
                                    </div>
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('front_asset/images/artist5.png') }}" class="track-1" />
                                    <div class="splide-inner">
                                        <div class="social-inner">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                        </div>
                                        <h3 class="bg3-c">NEW SINGLE</h3>
                                        <p class="bg3-d">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In dui nisl, luctus non condimentum non, ullamcorper vel
                                            nulla. Pellentesque libero risus, tincidunt sit amet dapib.
                                        </p>
                                    </div>
                                </li>
                                <li class="splide__slide">
                                    <img src="{{ asset('front_asset/images/artist6.png') }}" class="track-1" />
                                    <div class="splide-inner">
                                        <div class="social-inner">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                        </div>
                                        <h3 class="bg3-c">NEW SINGLE</h3>
                                        <p class="bg3-d">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In dui nisl, luctus non condimentum non, ullamcorper vel
                                            nulla. Pellentesque libero risus, tincidunt sit amet dapib.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    <section class="bg4">
        <div class="container">
            <iframe width="921" height="518" src="https://www.youtube.com/embed/ztVV54sPOns"
                title="Travel the Universe While Relaxation ★ Space Ambient Music" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </section>

    <section class="bg5">
        <div class="container">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <h3 class="bg5-a">About Us</h3>
                    <p class="bg5-b">
                        D'Angelo International Studio Corporation is the perfect
                        destination if you are looking for a music store near me. We are
                        committed to offering exceptional services and resources to
                        musicians and fans alike. As a musician or artist, you understand
                        the value of having a platform to showcase your talents and share
                        your songs with the world. Here's where we come in. We provide a
                        variety of services that are suited to your needs, regardless of
                        your experience level as an artist or if you are just getting
                        started. We can assist you with anything from producing your next
                        album to putting you in touch with the best music streaming
                        service to get the most exposure possible. And when it comes to
                        funding for music artists, we understand the difficulties you
                        encounter. That’s why we provide artist funding and assistance to
                        help you in realizing your aspirations related to music. Being
                        unique is essential in the competitive music production market. To
                        guarantee that your music reaches the largest audience possible,
                        we collaborate with the best music distribution service.
                        Regardless of your preference for physical record deals or digital
                        music distribution, we can assist you in navigating the industry
                        environment with ease. However, developing a brand and building a
                        relationship with your audience is just as important as just
                        making music videos. For this reason, we provide marketing
                        production services to aid in the promotion of your music and the
                        growth of your fan base. We are here to help you every step of the
                        way, from music publishing to album streaming. Furthermore, we
                        have you covered when it comes to music beats. Our vast selection
                        contains something for everyone, regardless of whether you're
                        searching for an inspirational beat or are prepared to buy
                        exclusive music beats. We have beats ownership possibilities and a
                        variety of genres available, so it has never been easy to find the
                        right beat.
                    </p>
                    <img src="{{ asset('front_asset/images/signature.png') }}" alt="signature" class="signature" />
                </div>
            </div>
        </div>
    </section>

    <section class="bg6">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="bg3-a">Best Online Record Shop</h3>
        <p class="bg3-b">
          Enter a world of rich musical diversity, where music record deals present a distinct audio experience.
        </p>
      </div>

      <!-- CARD 1 -->
      <div class="col-md-4 px-4">
        <div class="portfolio_classic_grid_wrapper">
          <article class="music-container" style="height: 375px">
            <audio id="audio_1" controls>
              <source src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/music_preview.mp3" type="audio/mpeg" />
            </audio>

            <div class="music-playing">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
              <div class="bar bar4"></div>
            </div>

            <div class="controls">
              <button class="btn-play" data-audio="audio_1"><span><i class="fa fa-play"></i></span></button>
              <button class="btn-pause" data-audio="audio_1"><span><i class="fa fa-pause"></i></span></button>
              <a href="#" target="_blank" class="lbl-btn-reset" style="pointer-events: none;">
                <span><i class="fa fa-external-link-square"></i></span>
              </a>
            </div>

            <div class="cover">
              <div class="static-card">
                <img src="{{ asset('front_asset/images/album-1.jpg') }}" alt="" />
              </div>
              <div class="flip-card">
                <img src="{{ asset('front_asset/images/album-1.jpg') }}" alt="" />
              </div>
            </div>
          </article>
        </div>
        <div class="portfolio_classic_content">
          <h3 class="bg6-a">Jazz</h3>
          <p class="bg6-b">
            Listen to albums by great jazz musicians to immerse yourself in the genre's ageless elegance, ranging from sensual ballads to lively swing tunes.
          </p>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="col-md-4 px-4">
        <div class="portfolio_classic_grid_wrapper">
          <article class="music-container" style="height: 375px">
            <audio id="audio_2" controls>
              <source src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/music_preview.mp3" type="audio/mpeg" />
            </audio>

            <div class="music-playing">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
              <div class="bar bar4"></div>
            </div>

            <div class="controls">
              <button class="btn-play" data-audio="audio_2"><span><i class="fa fa-play"></i></span></button>
              <button class="btn-pause" data-audio="audio_2"><span><i class="fa fa-pause"></i></span></button>
              <a href="#" target="_blank" class="lbl-btn-reset" style="pointer-events: none;">
                <span><i class="fa fa-external-link-square"></i></span>
              </a>
            </div>

            <div class="cover">
              <div class="static-card">
                <img src="{{ asset('front_asset/images/album-2.jpg') }}" alt="" />
              </div>
              <div class="flip-card">
                <img src="{{ asset('front_asset/images/album-2.jpg') }}" alt="" />
              </div>
            </div>
          </article>
        </div>
        <div class="portfolio_classic_content">
          <h3 class="bg6-a">Pop</h3>
          <p class="bg6-b">
            Featuring chart-topping tunes from today's biggest performers, our selection of pop records will have you ready to dance with their captivating melodies and memorable choruses.
          </p>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="col-md-4 px-4">
        <div class="portfolio_classic_grid_wrapper">
          <article class="music-container" style="height: 375px">
            <audio id="audio_3" controls>
              <source src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/music_preview.mp3" type="audio/mpeg" />
            </audio>

            <div class="music-playing">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
              <div class="bar bar4"></div>
            </div>

            <div class="controls">
              <button class="btn-play" data-audio="audio_3"><span><i class="fa fa-play"></i></span></button>
              <button class="btn-pause" data-audio="audio_3"><span><i class="fa fa-pause"></i></span></button>
              <a href="#" target="_blank" class="lbl-btn-reset" style="pointer-events: none;">
                <span><i class="fa fa-external-link-square"></i></span>
              </a>
            </div>

            <div class="cover">
              <div class="static-card">
                <img src="{{ asset('front_asset/images/album-3.jpg') }}" alt="" />
              </div>
              <div class="flip-card">
                <img src="{{ asset('front_asset/images/album-3.jpg') }}" alt="" />
              </div>
            </div>
          </article>
        </div>
        <div class="portfolio_classic_content">
          <h3 class="bg6-a">Rock</h3>
          <p class="bg6-b">
            Turn up the volume and fall to our collection of rock music, whether you like the raw intensity of classic rock or the adventurous sounds of alternative rock.
          </p>
        </div>
      </div>

      <!-- CARD 4 -->
      <div class="col-md-4 px-4 mt-4">
        <div class="portfolio_classic_grid_wrapper">
          <article class="music-container" style="height: 375px">
            <audio id="audio_4" controls>
              <source src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/music_preview.mp3" type="audio/mpeg" />
            </audio>

            <div class="music-playing">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
              <div class="bar bar4"></div>
            </div>

            <div class="controls">
              <button class="btn-play" data-audio="audio_4"><span><i class="fa fa-play"></i></span></button>
              <button class="btn-pause" data-audio="audio_4"><span><i class="fa fa-pause"></i></span></button>
              <a href="#" target="_blank" class="lbl-btn-reset" style="pointer-events: none;">
                <span><i class="fa fa-external-link-square"></i></span>
              </a>
            </div>

            <div class="cover">
              <div class="static-card">
                <img src="{{ asset('front_asset/images/album-4.jpg') }}" alt="" />
              </div>
              <div class="flip-card">
                <img src="{{ asset('front_asset/images/album-4.jpg') }}" alt="" />
              </div>
            </div>
          </article>
        </div>
        <div class="portfolio_classic_content">
          <h3 class="bg6-a">Electronic</h3>
          <p class="bg6-b">
            Our electronic selection has albums from pioneering artists, which feature throbbing beats that will transport you to a unique auditory experience.
          </p>
        </div>
      </div>

      <!-- CARD 5 -->
      <div class="col-md-4 px-4 mt-4">
        <div class="portfolio_classic_grid_wrapper">
          <article class="music-container" style="height: 375px">
            <audio id="audio_5" controls>
              <source src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/music_preview.mp3" type="audio/mpeg" />
            </audio>

            <div class="music-playing">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
              <div class="bar bar4"></div>
            </div>

            <div class="controls">
              <button class="btn-play" data-audio="audio_5"><span><i class="fa fa-play"></i></span></button>
              <button class="btn-pause" data-audio="audio_5"><span><i class="fa fa-pause"></i></span></button>
              <a href="#" target="_blank" class="lbl-btn-reset" style="pointer-events: none;">
                <span><i class="fa fa-external-link-square"></i></span>
              </a>
            </div>

            <div class="cover">
              <div class="static-card">
                <img src="{{ asset('front_asset/images/album-5.jpg') }}" alt="" />
              </div>
              <div class="flip-card">
                <img src="{{ asset('front_asset/images/album-5.jpg') }}" alt="" />
              </div>
            </div>
          </article>
        </div>
        <div class="portfolio_classic_content">
          <h3 class="bg6-a">Classical</h3>
          <p class="bg6-b">
            Invest in records that showcase the everlasting beauty of classical music with a wealth of undiscovered musical jewels, ranging from symphonies to sonatas.
          </p>
        </div>
      </div>

      <!-- CARD 6 -->
      <div class="col-md-4 px-4 mt-4">
        <div class="portfolio_classic_grid_wrapper">
          <article class="music-container" style="height: 375px">
            <audio id="audio_6" controls>
              <source src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/music_preview.mp3" type="audio/mpeg" />
            </audio>

            <div class="music-playing">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
              <div class="bar bar4"></div>
            </div>

            <div class="controls">
              <button class="btn-play" data-audio="audio_6"><span><i class="fa fa-play"></i></span></button>
              <button class="btn-pause" data-audio="audio_6"><span><i class="fa fa-pause"></i></span></button>
              <a href="#" target="_blank" class="lbl-btn-reset" style="pointer-events: none;">
                <span><i class="fa fa-external-link-square"></i></span>
              </a>
            </div>

            <div class="cover">
              <div class="static-card">
                <img src="{{ asset('front_asset/images/album-6.jpg') }}" alt="" />
              </div>
              <div class="flip-card">
                <img src="{{ asset('front_asset/images/album-6.jpg') }}" alt="" />
              </div>
            </div>
          </article>
        </div>
        <div class="portfolio_classic_content">
          <h3 class="bg6-a">Hip-hop</h3>
          <p class="bg6-b">
            Discover the beat of the streets with our collection of hip-hop albums, including inspirational choruses that perfectly reflect the spirit of a generation.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


    <section class="bg7">
        <div class="container-fluid p-0">
            <h3 class="bg3-a">Melodic Hub</h3>

            <div class="tg_background_list_wrapper four_cols">
                <div class="tg_background_list_column">
                    <div class="tg_background_list_content">
                        <div class="tg_background_list_title">
                            <h3>Music Spotlight</h3>
                        </div>
                        <div class="tg_background_list_link">
                            <div class="tg_background_list_desc">
                                In our Music Spotlight, which features a playlist collection,
                                behind-the-scenes content, and exclusive interviews, discover
                                the newest trends and emerging musicians.
                            </div>
                            <a class="button ghost" href="https://www.youtube.com/channel/UCBVjMGOIkavEAhyqpxJ73Dw"
                                target='"_blank"'>Subscribe</a>
                        </div>
                    </div>
                </div>
                <figure class="tg_background_img hover">
                    <div class="tg_background_list_overlay"></div>
                    <img src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/angel-jimenez-168185-unsplash.jpg"
                        alt="" />
                </figure>
                <div class="tg_background_list_column">
                    <div class="tg_background_list_content">
                        <div class="tg_background_list_title">
                            <h3>Artists Showcase</h3>
                        </div>
                        <div class="tg_background_list_link">
                            <div class="tg_background_list_desc">
                                In our Artist Showcase, we honor musical talent from across
                                the world by highlighting numerous voices, tales, and
                                inspirations that are advancing the music business.
                            </div>
                            <a class="button ghost" href="https://www.facebook.com/maroon5/" target='"_blank"'>Like
                                Page</a>
                        </div>
                    </div>
                </div>
                <figure class="tg_background_img">
                    <div class="tg_background_list_overlay"></div>
                    <img src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/melanie-van-leeuwen-83775.jpg"
                        alt="" />
                </figure>
                <div class="tg_background_list_column">
                    <div class="tg_background_list_content">
                        <div class="tg_background_list_title">
                            <h3>Throwback Hits</h3>
                        </div>
                        <div class="tg_background_list_link">
                            <div class="tg_background_list_desc">
                                This is a compilation of timeless masterpieces that will make
                                you feel nostalgic and forever inspired. These songs have had
                                a lasting impression on the history of music.
                            </div>
                            <a class="button ghost" href="http://instagram.com/maroon5" target='"_blank"'>Follow</a>
                        </div>
                    </div>
                </div>
                <figure class="tg_background_img">
                    <div class="tg_background_list_overlay"></div>
                    <img src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/pexels-photo-198793.jpeg"
                        alt="" />
                </figure>
                <div class="tg_background_list_column last">
                    <div class="tg_background_list_content">
                        <div class="tg_background_list_title">
                            <h3>Music News and Updates</h3>
                        </div>
                        <div class="tg_background_list_link">
                            <div class="tg_background_list_desc">
                                Stay up to date and inspired with our Music News & Updates,
                                your go-to source for the newest music events, and exclusive
                                announcements.
                            </div>
                            <a class="button ghost" href="https://twitter.com/maroon5" target='"_blank"'>Follow</a>
                        </div>
                    </div>
                </div>
                <figure class="tg_background_img">
                    <div class="tg_background_list_overlay"></div>
                    <img src="https://themes-themegoods.b-cdn.net/musico/demo/wp-content/uploads/2018/10/joe-watts-149049.jpg"
                        alt="" />
                </figure>
            </div>
        </div>
    </section>

    <section class="bg8">
        <div class="container">
            <h4 class="bg8-a">Digital Download Delights</h4>
            <p class="bg8-b">
                Explore D'Angelo International Studio Corporation's World of Musical
                Possibilities. For immediate access to the music you adore, get
                nonstop digital downloads straight from our website. Plus, you may
                express your creativity by making a song and uploading your creations
                for others to download and enjoy.
            </p>
            <div class="row mt-4">
                <div class="col-md-6 text-end col-6">
                    <a href="#"><img src="{{ asset('front_asset/images/app-store.png') }}"
                            class="appstore-img" /></a>
                </div>
                <div class="col-md-6 col-6">
                    <a href="#"><img src="{{ asset('front_asset/images/gplay.png') }}" class="appstore-img" /></a>
                </div>
            </div>
        </div>
    </section>

    <div id="popup" class="popup">
      <div class="popup-content">
          <img src="{{ asset('front_asset/images/logo.png') }}" class="logo" />
            <h3 class="popup-h3">Sign Up To Start Listening</h3>
            <div class="pop-div">
                <h4 class="pop-a">You'll need to sign up <br> on a different page.</h4>
                <p class="pop-b">
                    Click below to proceed.
                </p>
                <a href="{{ route('register') }}" class="popup-sign">Sign Up</a>
                <span class="close" id="closePopup">Dismiss</span>
            </div>
        </div>
    </div>

    <div id="overlay" class="overlay"></div>
@endsection

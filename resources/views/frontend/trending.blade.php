@extends('layout.trending_menu')
@section('content')
    <section class="sound1">

        <div class="sound-b">
            <div class="container">
                <div class="sound-inner-abc">
                    <div>
                        <form action="">
                            <div class="p-1 bg-dark rounded rounded-pill shadow-sm">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button id="button-addon2" type="submit" class="btn">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <input type="search" name="tag" placeholder="search for tags"
                                        aria-describedby="button-addon2" class="form-control text-white border-0" />
                                </div>
                            </div>
                        </form>
                    </div>
                    @foreach ($trendingTags as $tag)
                        <div class="soundb-inner">
                            <a href="{{ route('trending', ['tag' => $tag->id]) }}" class="soundb-a">{{ $tag->name }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sound-c">
            <div class="container">
                <h3 class="sounda-1 mb-4">Trending Tracks</h3>
                <div class="row">
                    @forelse ($trendingTracks as $track)
                        <div class="col-md-3 col-sm-4 col-12 mb-4">
                            <div class="card bg-dark text-white border-0 h-100">
                                <img src="{{ asset('storage/' . $track->cover_image_path) }}" class="card-img-top bg3-img"
                                    alt="{{ $track->title }}">
                                <div class="card-body p-2">
                                    <h5 class="card-title soundc-1 mb-0">{{ $track->title }}</h5>
                                    <p class="small mb-1">{{ $track->artist->name }}</p>
                                    <p class="soundc-3 mb-1">Plays: {{ $track->recent_plays_count }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-white">No trending tracks found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

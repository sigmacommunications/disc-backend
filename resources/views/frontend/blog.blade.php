@extends('layout.trending_menu')
@section('content')


<section class="blogs-one">
    <section class="b1sec1">
        <div class="container">
            <h1>NEWS AND BLOG</h1>
            <p>lorem ipsum dolor sit amet consectetur adipiscing elit aenean luctus urna ut lorem</p>
        </div>
    </section>
    <section class="b1sec2">
        <div class="container">
            <div class="row align-items-center">
                @foreach ($blogs as $blog)
                <div class="col-md-4 px-4">
                    <div class="blogss">
                        <a href="{{ route('blog.show', $blog->id) }}">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="">
                            <div class="author">
                                <p class="redtxt">{{ $blog->title }}</p>
                                <p>20 Dec 2024</p>
                                <p><i class="fa-light fa-messages"></i> 280</p>
                                <p><i class="fa-light fa-heart"></i> 89</p>
                            </div>
                            <p>{{ Str::limit($blog->description, 100) }}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</section>
@endsection

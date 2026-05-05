@extends('layout.trending_menu')

@section('content')

        <section class="b3sec2">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <div class="hello">
                            <div class="imgdiv">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="img-fluid">
                            </div>
                            <div class="content">
                                <h2>{{ $blog->title }}</h2>
                                <p>{{ $blog->description }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection

@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option" style="background: #0b0c2a; margin-top: -30px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories.html">Categories</a>
                        <a href="#">{{ $show->genre }}</a>
                        <span>{{ $show->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="anime__video__player">
                        <video id="player" playsinline controls
                            data-poster="{{ asset('assets/thumbnails/' . $episode->thumbnail) }}">
                            <source src="{{ asset('assets/videos/' . $episode->video) }}" type="video/mp4" />
                            <!-- Captions are optional -->
                            <track kind="captions" label="English captions" src="#" srclang="en" default />
                        </video>
                    </div>
                    <div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>List Name</h5>
                        </div>
                        @foreach ($episodesInfo as $cEpisodeInfo)
                            @if ($episode->name === $cEpisodeInfo->episode_name)
                                <a
                                    href="{{ route('anime.watching', ['show_id' => $cEpisodeInfo->show_id, 'episode_id' => $cEpisodeInfo->episode_name]) }} disabled">Ep
                                    {{ $cEpisodeInfo->episode_name }}</a>
                            @else
                                <a
                                    href="{{ route('anime.watching', ['show_id' => $cEpisodeInfo->show_id, 'episode_id' => $cEpisodeInfo->episode_name]) }}">Ep
                                    {{ $cEpisodeInfo->episode_name }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews</h5>
                        </div>
                        @foreach ($comments as $comment)
                            <div class="anime__review__item">
                                <div class="anime__review__item__pic">
                                    <img src="{{ asset('assets/' . $comment->image) }}" alt="">
                                </div>
                                <div class="anime__review__item__text">
                                    <h6>{{ $comment->user_name }} - <span>{{ $comment->created_at }}</span></h6>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        <form action="{{ route('store.comment', $show->id) }}" method="POST">
                            @csrf
                            <textarea name=comment placeholder="Your Comment"></textarea>
                            <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->
@endsection

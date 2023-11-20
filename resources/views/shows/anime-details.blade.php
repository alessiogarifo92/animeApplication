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
                        <span>{{ $show->genre }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad" style="margin-top: -30px">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="{{ asset('assets/' . $show->image) }}">
                            <div class="comment"><i class="fa fa-comments"></i>{{ $numberComments }}</div>
                            <div class="view"><i class="fa fa-eye"></i> {{ $viewsShows }}</div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3>{{ $show->name }}</h3>
                            </div>

                            <p>{{ $show->description }}</p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Type:</span> {{ $show->type }}</li>
                                            <li><span>Studios:</span> {{ $show->studios }}</li>
                                            <li><span>Date aired:</span> {{ $show->date_aired }}</li>
                                            <li><span>Status:</span> {{ $show->status }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Genre:</span> {{ $show->genre }}</li>

                                            <li><span>Duration:</span> {{ $show->duration }}</li>
                                            <li><span>Quality:</span> {{ $show->quality }}</li>
                                            <li><span>Views:</span>{{ $viewsShows }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if (Session::has('follow'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('follow') }}
                                </div>
                            @endif

                            <div class="anime__details__btn" style="margin: 0">
                                @if (isset(Auth::user()->id))
                                    @if ($following > 0)
                                        <button disabled type="submit" class="follow-btn"><i
                                                class="fa fa-heart-o"></i>Following</button>
                                    @else
                                        <form action="{{ route('anime.follow', $show->id) }}" method="POST">
                                            @csrf
                                            <input hidden type="text" name="show_image" value="{{ $show->image }}">
                                            <input hidden type="text" name="show_name" value="{{ $show->name }}">
                                            <button type="submit" class="follow-btn"><i class="fa fa-heart-o"></i>
                                                Follow</button>
                                        </form>
                                    @endif
                                    {{-- passero come secondo parametro episode_id => 1 perche tutte le volte che clickero mandero alla schermata del primo episodio, poi lo potro scegliere --}}
                                    <a style="padding: 0"
                                        href="{{ route('anime.watching', ['show_id' => $show->id, 'episode_id' => '1']) }}"
                                        type="submit" class="watch-btn"><span>Watch Now</span> <i
                                            class="fa fa-angle-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (Session::has('comment'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('comment') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-8 col-md-8">
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
                                    <h6>{{ $comment->user_name }} - <span>
                                            {{-- @php
                                    function getTimeAgo($carbonObject) {
                                        return $carbonObject->diffForHumans()
                                        ;
                                    }
                                    echo getTimeAgo($comment->created_at);
                                @endphp --}}
                                            {{ $comment->created_at }}</span></h6>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (isset(Auth::user()->id))
                        {

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
                        }
                    @endif
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>you might like...</h5>
                        </div>
                        @foreach ($randomShows as $randomShow)
                            <div class="product__sidebar__view__item set-bg"
                                data-setbg="{{ asset('assets/' . $randomShow->image) }}">
                                <div class="ep">18 / ?</div>
                                <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                <h5><a href="{{ route('anime.details', $randomShow->id) }}">{{ $randomShow->name }}</a>
                                </h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->
@endsection

@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option" style="background: #0b0c2a; margin-top: -30px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <span>{{ $category_name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>{{ $category_name }}</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            @if ($animeList->count() > 0)
                                @foreach ($animeList as $cAnime)
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <div class="product__item__pic set-bg"
                                                data-setbg="{{ asset('assets/' . $cAnime->image) }}">
                                                <div class="ep">18 / 18</div>
                                                <div class="comment"><i class="fa fa-comments"></i> 11</div>
                                                <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                            </div>
                                            <div class="product__item__text">
                                                <ul>
                                                    <li>{{ $cAnime->status }}</li>
                                                    <li>{{ $cAnime->type }}</li>
                                                </ul>
                                                <h5><a
                                                        href="{{ route('anime.details', $cAnime->id) }}">{{ $cAnime->name }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-lg-8 col-md-8 col-sm-6"
                                    style="color: white;  position: absolute;left: 25%;">
                                    <h4>NO MOVIES FOR THIS CATEGORY</h4>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                        </div>
                        <!-- </div>
                            </div>         -->
                    </div>
                    <div class="product__sidebar__comment">
                        <div class="section-title">
                            <h5>FOR YOU</h5>
                        </div>
                        @foreach ($forYouShows as $forYouShow)
                            <div class="product__sidebar__comment__item">
                                <div class="product__sidebar__comment__item__pic">
                                    <img width="100px" src="{{ asset('assets/' . $forYouShow->image) }}" alt="">
                                </div>
                                <div class="product__sidebar__comment__item__text">
                                    <ul>
                                        <li>{{ $forYouShow->status }}</li>
                                        <li>{{ $forYouShow->type }}</li>
                                    </ul>
                                    <h5><a
                                            href="{{ route('anime.details', $forYouShow->id) }}">{{ $forYouShow->name }}</a>
                                    </h5>
                                    <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection

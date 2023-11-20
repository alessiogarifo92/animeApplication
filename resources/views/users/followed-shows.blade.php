@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option" style="background: #0b0c2a; margin-top: -30px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Yours followed shows</span>
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
                                        <h4>Yours followed shows</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            @if ($followedShows->count() > 0)
                                @foreach ($followedShows as $followedShow)
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <div class="product__item__pic set-bg"
                                                data-setbg="{{ asset('assets/' . $followedShow->show_image) }}">
                                                <div class="ep">18 / 18</div>
                                                <div class="comment"><i class="fa fa-comments"></i> 11</div>
                                                <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                            </div>
                                            <div class="product__item__text">
                                                <h5><a
                                                        href="{{ route('anime.details', $followedShow->id) }}">{{ $followedShow->show_name }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-lg-8 col-md-8 col-sm-6"
                                    style="color: white;  position: absolute;left: 25%;">
                                    <h4>YOU DON'T FOLLOW ANY MOVIES</h4>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection

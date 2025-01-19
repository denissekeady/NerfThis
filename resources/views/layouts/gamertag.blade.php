@extends('layouts.master')

@section('title')
  Gamer Details
@endsection

@section('background')
    style="background: #cccccc"
@endsection

@section('content')
    <div class= "welcomestrip-container" style="background: linear-gradient(to bottom, rgba(255,255,255,0) 50%, #cccccc 100%), linear-gradient(to top, rgba(255,255,255,0) 70%, #cccccc 100%), url('{{ asset('images/gamertag_bg.JPEG') }}') center center; background-repeat: no-repeat; background-size: contain; height:130vh">
        <p class="whead">{{$gamer->username}}</p><p class="pagedescription">All posts from {{$gamer->username}}</p><br>
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 d-flex justify-content-between align-items-center mb-4">
                        <form action="{{ url('gamertag/'.$gamer->userID) }}" method="GET" class="d-flex align-items-center">
                            <select class="form-select me-2" name="orderby" style="width:6cm; background-color:rgba(255,255,255,0.8);">
                                <option value="ab">Newest</option>
                                <option value="bc" {{ request('orderby') == 'bc' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="cd" {{ request('orderby') == 'cd' ? 'selected' : '' }}>Lowest Rated</option>
                                <option value="de" {{ request('orderby') == 'de' ? 'selected' : '' }}>Most Reviews</option>
                                <option value="ef" {{ request('orderby') == 'ef' ? 'selected' : '' }}>Least Reviews</option>
                            </select>

                            <button type="submit" class="btn btn-primary me-2 btn-outline-gamertagfilter" style="width:2.7cm">Filter</button>
                            <a class="btn btn-secondary me-2 btn-outline-gamertagreset" style="width:2.7cm" href="{{ url('gamertag/'.$gamer->userID) }}">Reset</a>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="align-items-center row">
                            <p>Total posts: {{ $gamer->total_posts }}</p>
                        </div>
                        @foreach($posts as $post)
                            @if ($loop->index <= 3)
                                <div class="candidate-list-box card mt-4" style="background-color: rgba(255,255,255,0.7); height: 140px;">
                                    <div class="p-4 card-body">
                                        <div class="align-items-center row">
                                            <div class="col-auto">
                                                @if ($post->posttype == 'Advice')
                                                    <div class="candidate-list-images">
                                                        <span class="badge bg-success ms-1"><i class="mdi mdi-star align-middle"></i>{{ round($post->avg_rating, 1) }}<br>{{$post->total_reviews}} reviews</span>
                                                    </div>
                                                @else
                                                    @if ($post->chartype == 'Tank')
                                                        <img src="{{ asset('images/tank_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                    @elseif ($post->chartype == 'Damage')
                                                        <img src="{{ asset('images/damage_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                    @else
                                                        <img src="{{ asset('images/support_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="candidate-list-content mt-3 mt-lg-0">
                                                    <h5 class="fs-19 mb-0">
                                                        <a class="primary-link" href="{{ url('post_detail/' . $post->postID) }}">
                                                            {{ $post->title }}
                                                        </a>
                                                    </h5>
                                                    <p class="text-muted" style="margin-bottom:0; padding:0">{{ $post->username }} | {{ $post->no_of_hrs }}hrs</p>
                                                    <p style="margin-top:0; padding:0">Platform: {{ $post->platform }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <div class="badges-container d-flex flex-wrap justify-content-end">
                                                    @if ($post->posttype == 'Advice')
                                                        <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e39dc1; color: white">
                                                            {{ $post->posttype }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e3bc91;; color: white">
                                                            {{ $post->posttype }}
                                                        </span>
                                                    @endif

                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#477fa0; color: white">
                                                        {{ $post->charname }}
                                                    </span>
                                                    @if ($post->chartype == 'Tank')
                                                        <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#f9a32c; color: white">
                                                            {{ $post->chartype }}
                                                        </span>
                                                    @elseif ($post->chartype == 'Damage')
                                                        <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e52128; color: white">
                                                            {{ $post->chartype }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#02a34a; color: white">
                                                            {{ $post->chartype }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
    <br><br><br>
    @foreach ($posts as $post)
        @if ($loop->index > 3)
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="candidate-list-box card mt-4" style="background-color: rgba(255,255,255,0.7); height: 140px;">
                                <div class="p-4 card-body">
                                    <div class="align-items-center row">
                                        <div class="col-auto">
                                            @if ($post->posttype == 'Advice')
                                                <div class="candidate-list-images">
                                                    <span class="badge bg-success ms-1"><i class="mdi mdi-star align-middle"></i>{{ round($post->avg_rating, 1) }}<br>{{$post->total_reviews}} reviews</span>
                                                </div>
                                            @else
                                                @if ($post->chartype == 'Tank')
                                                    <img src="{{ asset('images/tank_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                @elseif ($post->chartype == 'Damage')
                                                    <img src="{{ asset('images/damage_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                @else
                                                    <img src="{{ asset('images/support_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="candidate-list-content mt-3 mt-lg-0">
                                                <h5 class="fs-19 mb-0">
                                                    <a class="primary-link" href="{{ url('post_detail/' . $post->postID) }}">
                                                        {{ $post->title }}
                                                    </a>
                                                </h5>
                                                <p class="text-muted" style="margin-bottom:0; padding:0">{{ $post->username }} | {{ $post->no_of_hrs }}hrs</p>
                                                <p style="margin-top:0; padding:0">Platform: {{ $post->platform }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <div class="badges-container d-flex flex-wrap justify-content-end">
                                                @if ($post->posttype == 'Advice')
                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e39dc1; color: white">
                                                        {{ $post->posttype }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e3bc91;; color: white">
                                                        {{ $post->posttype }}
                                                    </span>
                                                @endif
                                                <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#477fa0; color: white">
                                                    {{ $post->charname }}
                                                </span>
                                                @if ($post->chartype == 'Tank')
                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#f9a32c; color: white">
                                                        {{ $post->chartype }}
                                                    </span>
                                                @elseif ($post->chartype == 'Damage')
                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e52128; color: white">
                                                        {{ $post->chartype }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#02a34a; color: white">
                                                        {{ $post->chartype }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
            </section>
        @endif
    @endforeach





@endsection
@extends('layouts.master')

@section('title')
  Assistance page
@endsection

@section('background')
    style="background: #f6efe9"
@endsection

@section('content')
    <div class="welcomestrip-container" style="background: linear-gradient(to bottom, rgba(255,255,255,0) 70%, #f6efe9 100%), linear-gradient(to top, rgba(255,255,255,0) 70%, #f6efe9 100%), url('images/assistance_bg.JPEG') center center; background-repeat: no-repeat; background-size: cover; height:130vh">
        <p class="whead">Assistance</p>
        <p class="pagedescription">Do you need help or have questions about the gameplay?</p><p class="pagedescription">Create a post and one of our gamers will help you soon!</p><br>
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 d-flex justify-content-between align-items-center mb-4">
                        <form action="{{ url('assistance') }}" method="GET" class="d-flex align-items-center">
                            <select class="form-select me-2" name="chartype" style="width:6cm; background-color:rgba(255,255,255,0.8);">
                                <option value="">All Roles</option>
                                <option value="Tank" {{ request('chartype') == 'Tank' ? 'selected' : '' }}>Tank</option>
                                <option value="Damage" {{ request('chartype') == 'Damage' ? 'selected' : '' }}>Damage</option>
                                <option value="Support" {{ request('chartype') == 'Support' ? 'selected' : '' }}>Support</option>
                            </select>

                            <select class="form-select me-2" name="orderby" style="width:6cm; background-color:rgba(255,255,255,0.8);">
                                <option value="ab">Newest</option>
                                <option value="bc" {{ request('orderby') == 'bc' ? 'selected' : '' }}>Most Reviews</option>
                                <option value="cd" {{ request('orderby') == 'cd' ? 'selected' : '' }}>Least Reviews</option>
                            </select>

                            <button type="submit" class="btn btn-primary me-2 btn-outline-assistfilter" style="width:2.7cm">Filter</button>
                            <a class="btn btn-secondary me-2 btn-outline-assistreset" style="width:2.7cm" href="{{ url('assistance') }}">Reset</a>
                        </form>
                    </div>
                    <div class="col-lg-2 text-end">
                        <a class="btn btn-primary btn-outline-assistcreatepost" href="create_post">Create Post</a>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="align-items-center row">
                            <p>Total posts: {{ $total }}</p>
                        </div>
                        @if ($assistposts)
                            @foreach($assistposts as $post)
                                @if ($loop->index <= 3)
                                    <div class="candidate-list-box card mt-4" style="background-color: rgba(255,255,255,0.7); height: 140px;">
                                        <div class="p-4 card-body">
                                            <div class="align-items-center row">
                                                <div class="col-lg-1">
                                                    <div style="margin-right: 15px; margin-left: 10px;">
                                                        @if ($post->chartype == 'Tank')
                                                            <img src="{{ asset('images/tank_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                        @elseif ($post->chartype == 'Damage')
                                                            <img src="{{ asset('images/damage_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                        @else
                                                            <img src="{{ asset('images/support_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
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
                                                <div class="col-lg-3 text-right">
                                                    <div class="badges-container d-flex flex-wrap justify-content-end">
                                                        <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e3bc91; color: white">
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
                        @else
                            <p style="font-weight:bold">No assistance posts. Be the first to post!</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <br><br><br><br>

    @if ($assistposts)
        @foreach ($assistposts as $post)
            @if ($loop->index > 3)
                <section class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="candidate-list-box card mt-4" style="background-color: rgba(255,255,255,0.7); height: 140px;">
                                    <div class="p-4 card-body">
                                        <div class="align-items-center row">
                                            <div class="col-lg-1">
                                                <div style="margin-right: 15px; margin-left: 10px;">
                                                    @if ($post->chartype == 'Tank')
                                                        <img src="{{ asset('images/tank_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                    @elseif ($post->chartype == 'Damage')
                                                        <img src="{{ asset('images/damage_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                    @else
                                                        <img src="{{ asset('images/support_icon.png') }}" style="width: 70px; border-radius: 50%;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
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
                                            <div class="col-lg-3 text-right">
                                                <div class="badges-container d-flex flex-wrap justify-content-end">
                                                    <span class="badge bg-soft-secondary fs-14 mt-1 mx-1" style="background-color:#e3bc91; color: white">
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
                    </div>
                </section>
            @endif
        @endforeach
    @endif
    <br><br><br>
@endsection
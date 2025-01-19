@extends('layouts.master')

@section('title')
    Welcome page
@endsection

@section('background')
  style="background-color: #e4ecf7"
@endsection

@section('content')
  <!-- display success message -->
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- display username modification -->
  @if (session('modified'))
    <div class="alert alert-info">
      {{ session('modified') }}
    </div>
  @endif

  <!-- display errors -->
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class= "welcomestrip-container" style="background: linear-gradient(to bottom, rgba(255,255,255,0) 90%,rgba(228,236,247,1) 100%), linear-gradient(to top, rgba(255,255,255,0) 90%,rgba(228,236,247,1) 100%), url('images/welcome_bg.JPEG'); background-repeat: no-repeat; background-size: cover;">
    <br><br><br><br>
    <p class="welcomehead">Welcome to <span class="nerthis">Nerf This</span></p>
    <p style="text-align: center">Learn about how to play your character in Overwatch 2 from other players!<br>
    Post advice or ask for assistance, all the help you need is here</p>
    <br><br>
    <br><br>
    <br>
  

  </div>

  <br><br>

<!-- Character Sections -->
  <div class="container">
    <div class="row">
      <!-- Tank Section -->
      <div class="col-md-4 characterstrip" style="background-image: url('images/dva_background.JPEG'); background-size: cover; background-position: center; height: 1200px"">
        <p class="chartypeheads">Tank</p>
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-lg-9 d-flex align-items-center">
            <form method="GET" action="{{ url('/') }}" class="d-flex align-items-center">
              <input type="hidden" name="chartype" value="Tank">
              <select class="form-select me-2" name="orderby" style="width:8.6cm; background-color: rgba(255,255,255,0.7)">
                <option value="ab">Newest</option>
                <option value="bc" {{ request('orderby') == 'bc' ? 'selected' : '' }}>Highest Rated</option>
                <option value="cd" {{ request('orderby') == 'cd' ? 'selected' : '' }}>Lowest Rated</option>
                <option value="de" {{ request('orderby') == 'de' ? 'selected' : '' }}>Most Reviews</option>
                <option value="ef" {{ request('orderby') == 'ef' ? 'selected' : '' }}>Least Reviews</option>
              </select>

              <button type="submit" class="btn btn-outline-homefilter">Filter</button>
            </form>
          </div>
        </div>
        <hr>
        @if ($tankposts)
          @foreach($tankposts as $post)
            @if ($loop->index <= 12)
              <div class="m-portlet__body">
                <div class="tab-content">
                  <div class="tab-pane active">
                    <div class="m-widget4 m-widget4--progress">
                      <div class="m-widget4__item">
                        <div class="m-widget4__info">
                          <span class="m-widget4__title">
                            <a href="{{ url('post_detail/'.$post->postID)}}" style="color: #f45bbd; font-weight:bold">{{$post->title}}</a>
                          </span>
                          <br>
                          <span class="m-widget4__sub">
                            {{$post->charname}} | {{$post->platform}}
                          </span>
                        </div>
                        <div class="m-widget4__info" style="text-align: right">
                          <span class="m-widget4__title">
                            @if ($post->posttype == 'Advice')
                              Rating: ★{{ round($post->avg_rating, 1) }}
                            @else
                              {{$post->posttype}}
                            @endif
                          </span>
                          <br>
                          <span class="m-widget4__sub">
                            {{$post->total_reviews}} reviews
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
            @endif
          @endforeach
        @else
          No posts yet. Be the first to post!<br>
          <a href="{{url("create_post")}}">Create Post</a>
        @endif
      </div>

      <!-- Damage Section -->
      <div class="col-md-4 characterstrip" style="background-image: url('images/widowmaker_background.JPEG'); background-size: cover; background-position: center;">
        <p class="chartypeheads">Damage</p>
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-lg-9 d-flex align-items-center">
            <form method="GET" action="{{ url('/') }}" class="d-flex align-items-center">
              <input type="hidden" name="chartype" value="Damage">
              <select class="form-select me-2" name="orderby" style="width:8.6cm; background-color: rgba(255,255,255,0.7)">
                <option value="ab">Newest</option>
                <option value="bc" {{ request('orderby') == 'bc' ? 'selected' : '' }}>Highest Rated</option>
                <option value="cd" {{ request('orderby') == 'cd' ? 'selected' : '' }}>Lowest Rated</option>
                <option value="de" {{ request('orderby') == 'de' ? 'selected' : '' }}>Most Reviews</option>
                <option value="ef" {{ request('orderby') == 'ef' ? 'selected' : '' }}>Least Reviews</option>
              </select>

              <button type="submit" class="btn btn-outline-homefilter">Filter</button>
            </form>
          </div>
        </div>
        <hr>
        @if ($damageposts)
          @foreach($damageposts as $post)
            @if ($loop->index <= 12)
              <div class="m-portlet__body">
                <div class="tab-content">
                  <div class="tab-pane active">
                    <div class="m-widget4 m-widget4--progress">
                      <div class="m-widget4__item">
                        <div class="col-lg-3 m-widget4__info">
                          <span class="m-widget4__title">
                            <a href="{{ url('post_detail/'.$post->postID)}}" style="color: #f45bbd; font-weight:bold">{{$post->title}}</a>
                          </span>
                          <br>
                          <span class="m-widget4__sub">
                            {{$post->charname}} | {{$post->platform}}
                          </span>
                        </div>
                        <div class="m-widget4__info" style="text-align: right">
                          <span class="m-widget4__title">
                            @if ($post->posttype == 'Advice')
                              Rating: ★{{ round($post->avg_rating, 1) }}
                            @else
                              {{$post->posttype}}
                            @endif
                          </span>
                          <br>
                          <span class="m-widget4__sub">
                            {{$post->total_reviews}} reviews
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
            @endif
          @endforeach
        @else
          No posts yet. Be the first to post!<br>
          <a href="{{url("create_post")}}">Create Post</a>
        @endif
      </div>

      <!-- Support Section -->
      <div class="col-md-4 characterstrip" style="background-image: url('images/mercy_background.JPEG'); background-size: cover; background-position: center;">
        <p class="chartypeheads">Support</p>
        <div class="row justify-content-between align-items-center mb-4">
          <div class="col-lg-9 d-flex align-items-center">
            <form method="GET" action="{{ url('/') }}" class="d-flex align-items-center">
            <input type="hidden" name="chartype" value="Support">
              <select class="form-select me-2" name="orderby" style="width:8.6cm; background-color: rgba(255,255,255,0.7)">
                <option value="ab">Newest</option>
                <option value="bc" {{ request('orderby') == 'bc' ? 'selected' : '' }}>Highest Rated</option>
                <option value="cd" {{ request('orderby') == 'cd' ? 'selected' : '' }}>Lowest Rated</option>
                <option value="de" {{ request('orderby') == 'de' ? 'selected' : '' }}>Most Reviews</option>
                <option value="ef" {{ request('orderby') == 'ef' ? 'selected' : '' }}>Least Reviews</option>
              </select>

              <button type="submit" class="btn btn-outline-homefilter" >Filter</button>
            </form>
          </div>
        </div>
        <hr>
        @if ($supportposts)
          @foreach($supportposts as $post)
            @if ($loop->index <= 12)
            <div class="m-portlet__body">
                <div class="tab-content">
                  <div class="tab-pane active">
                    <div class="m-widget4 m-widget4--progress">
                      <div class="m-widget4__item">
                        <div class="col-lg-3 m-widget4__info">
                          <span class="m-widget4__title">
                            <a href="{{ url('post_detail/'.$post->postID)}}" style="color: #f45bbd; font-weight:bold">{{$post->title}}</a>
                          </span>
                          <br>
                          <span class="m-widget4__sub">
                            {{$post->charname}} | {{$post->platform}}
                          </span>
                        </div>
                        <div class="m-widget4__info" style="text-align: right">
                          <span class="m-widget4__title">
                            @if ($post->posttype == 'Advice')
                              Rating: ★{{ round($post->avg_rating, 1) }}
                            @else
                              {{$post->posttype}}
                            @endif
                          </span>
                          <br>
                          <span class="m-widget4__sub">
                            {{$post->total_reviews}} reviews
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            @endif
          @endforeach
        @else
          No posts yet. Be the first to post!<br>
          <a href="{{url("create_post")}}">Create Post</a>
        @endif
      </div>
    </div>
  </div>
@endsection
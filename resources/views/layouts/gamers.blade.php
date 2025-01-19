@extends('layouts.master')

@section('title')
  Users List
@endsection

@section('background')
    style="background: #cad8db"
@endsection

@section('content')
  <div class= "welcomestrip-container" style="background: linear-gradient(to bottom, rgba(255,255,255,0) 70%, #cad8db 100%), linear-gradient(to top, rgba(255,255,255,0) 70%, #cad8db 100%), url('images/gamers_bg.JPEG') center center; background-repeat: no-repeat; background-size: contain; height:130vh">
    <p class="whead">Gamers</p>
    <p class="pagedescription">See our gamers who are helping out in the OW2 community!</p><br>
    <div class="container">
      <div class="row" >
        <div class="col-lg-10 mx-auto">
          <div class="career-search mb-60" style="color: #000000">
            <form action="{{ url('gamers') }}" method="GET" class="career-form mb-60">
              <div class="row">
                <div class="col-md-6 col-lg-3 my-3" >
                  <div class="select-container">
                    <select name="orderby" class="custom-select">
                      <option value="">Sort By</option>
                      <option value="ab" {{ request('orderby') == 'ab' ? 'selected' : '' }}>Highest Rated</option>
                      <option value="bc" {{ request('orderby') == 'bc' ? 'selected' : '' }}>Lowest Rated</option>
                      <option value="cd" {{ request('orderby') == 'cd' ? 'selected' : '' }}>Most Posts</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-lg-3 my-3">
                  <button type="submit" class="btn btn-lg btn-block btn-light btn-gamers" style="height:50px; font-size:16px; width:100px;">
                    Search
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="filter-result">
            <p class="mb-30 ff-montserrat" style="font-size: 18px">Total Gamers: {{$total}}</p>
            @foreach ($gamers as $gamer)
              @if ($loop->index <= 2)
                <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                  <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                    <div class="img-holder" style="margin-right: 20px;">
                      @if ($gamer->user_avg_rating == 0)
                        N/A
                      @else
                        {{ round($gamer->user_avg_rating, 1) }}★
                      @endif
                    </div>
                    <div class="job-content">
                      <a class="h5 primary-link mb-1" href="{{ url('gamertag/' . $gamer->userID) }}">
                        {{$gamer->username}}
                      </a>
                      <span class="text-muted">
                        {{$gamer->no_of_hrs}} hrs
                      </span>
                    </div>
                  </div>
                  <div class="job-right ml-auto flex-shrink-0">
                    <a href="{{ url('gamertag/' . $gamer->userID) }}" class="btn d-block w-100 d-sm-inline-block btn-light" style="background-color:rgba(199,218,224,0.7)">
                      {{$gamer->total_posts}} posts
                    </a>
                  </div>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  @foreach ($gamers as $gamer)
    @if ($loop->index > 2)
      <div class="container">
        <div class="row" >
          <div class="col-lg-10 mx-auto">
            <div class="filter-result">
              <div class="career-search mb-60" style="color: #000000">
                <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                  <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                    <div class="img-holder" style="margin-right: 20px;">
                      @if ($gamer->user_avg_rating == 0)
                        N/A
                      @else
                        {{ round($gamer->user_avg_rating, 1) }}★
                      @endif
                    </div>
                    <div class="job-content">
                      <a class="h5 primary-link mb-1" href="{{ url('gamertag/' . $gamer->userID) }}">
                        {{$gamer->username}}
                      </a>
                      <span class="text-muted">
                        {{$gamer->no_of_hrs}} hrs
                      </span>
                    </div>
                  </div>
                  <div class="job-right ml-auto flex-shrink-0">
                    <a href="{{ url('gamertag/' . $gamer->userID) }}" class="btn d-block w-100 d-sm-inline-block btn-light" style="background-color:rgba(199,218,224,0.7)">
                      {{$gamer->total_posts}} posts
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  @endforeach
@endsection
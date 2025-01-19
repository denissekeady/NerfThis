@extends('layouts.master')

@section('title')
  Item List
@endsection

@section('background')
  @if ($post->posttype == 'Advice')
    style="background-color: #b5cbd6"
  @else
    style="background: #e2d7e8"
  @endif
@endsection

@section('content')
  @if ($post->posttype == 'Advice')
    <div class= "welcomestrip-container" style="background: linear-gradient(to bottom, rgba(255,255,255,0) 80%, #b5cbd6 100%), linear-gradient(to top, rgba(255,255,255,0) 70%, #b5cbd6 100%), url('{{ asset('images/advicep_bg.JPEG') }}') center; background-repeat: no-repeat; background-size: cover; height:100vh">
  @else
    <div class= "welcomestrip-container" style="background: linear-gradient(to bottom, rgba(255,255,255,0) 70%, #e2d7e8 100%), linear-gradient(to top, rgba(255,255,255,0) 80%, #e2d7e8 100%), url('{{ asset('images/assistp_bg.JPEG') }}') center center; background-repeat: no-repeat; background-size: cover; height:100vh">
  @endif
      <div class="container post-container">
        <div class="col-lg-12 post-card card mb-4">
          <div class="card-header">
            <h3 class="post-title whead">{{$post->title}}</h3>
          </div>

          <div class="card-body">
            <div class="post-meta d-flex justify-content-between align-items-center">
              <div class="post-username">
                <strong>{{$post->username}}</strong> | {{$post->no_of_hrs}} hrs
              </div>
              <div>
                @if ($post->posttype == 'Advice')
                  <span class="badge bg" style="background-color:#e39dc1; color: white">{{$post->posttype}}</span>
                  <span class="badge bg" style="background-color:#6dacb3; color: white">{{$post->charname}}</span>
                @else
                  <span class="badge bg" style="background-color:#e3bc91; color: white">{{$post->posttype}}</span>
                  <span class="badge bg" style="background-color:#a98cbb; color: white">{{$post->charname}}</span>
                @endif
                @if ($post->chartype == 'Tank')
                  <span class="badge bg" style="background-color:#f9a32c; color: white">{{$post->chartype}}</span> 
                @elseif ($post->chartype == 'Damage')
                  <span class="badge bg" style="background-color:#e52128; color: white">{{$post->chartype}}</span> 
                @else
                  <span class="badge bg" style="background-color:#02a34a; color: white">{{$post->chartype}}</span> 
                @endif
              </div>
            </div>
            
            <hr>

            <div class="post-reviews">
              @if ($total_reviews > 0)
                @if ($post->posttype == 'Advice')
                  <p>
                    <strong>Average Rating:</strong> 
                    <span>{{$avg_rating}}/5 </span><span class="text-warning">★</span>
                  </p>
                @endif
                <p>
                  <strong>Total Reviews:</strong> 
                  <span>{{ $total_reviews }}</span>
                </p>
              @else
                @if ($post->posttype == 'Advice')
                  <p class="text-muted">★ No reviews ★</p>
                @else
                  <p class="text-muted">★ Need Assistance ★</p>
                @endif
              @endif
            </div>

            <div class="post-content">
              <p>{!! nl2br(e($post->content)) !!}</p>
            </div>
          </div>

          <div class="card-footer d-flex justify-content-between">
            <small class="text-muted">{{$post->created_at}}</small>
            <form action="{{url('delete_post_action/'.$post->postID)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger btn-sm" style="font-size:15px;">Delete Post</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Display comments -->
    <div class="comments-section-wrapper">
      <div class="comments-section">
        @if ($post->posttype == 'Advice')
          <h3 class="comments-heading">Reviews</h3>
        @else
          <h3 class="comments-heading">Comments</h3>
        @endif

        @if (empty($reviews))
          <p class="no-comments">No comments yet.</p>
        @else
          <ul class="comments-list">
            @foreach ($reviews as $review)
              <li class="comment-item">
                <div class="comment-details">
                  <strong class="comment-author">{{ $review->username }}</strong> 
                  <span class="comment-date">({{ $review->created_at }})</span>
                </div>
                @if ($post->posttype == 'Advice')
                  <p class="comment-rating">Rating: {{ $review->rating }} ★</p>
                @endif
                <p class="comment-content">{{ $review->content }}</p>

                @if (request()->query('edit') == $review->reviewID)
                  @if(!$userBanned && !$commentsDisabled)
                    <form id="reviewForm" action="{{ url('edit_review_action/' . $review->reviewID) }}" method="POST" class="edit-comment-form">
                      @csrf
                      @if ($post->posttype == 'Advice')
                        <div class="form-group">
                          <label for="rating">Rating:</label>
                          <input type="number" name="rating" class="form-control" value="{{ $review->rating }}" id="rating" required>
                          <div id="ratingError" class="error-message"></div>
                        </div>
                      @endif
                      <div class="form-group">
                        <label for="content">Edit Comment:</label>
                        <textarea name="content" class="form-control" rows="3" id="content" required>{{ $review->content }}</textarea>
                        <div id="contentError" class="error-message"></div> 
                      </div>
                      @if ($post->posttype == 'Advice')
                        <button type="submit" class="btn btn-primary me-2 btn-outline-advicecomment">Update Comment</button>
                      @else
                        <button type="submit" class="btn btn-primary me-2 btn-outline-assistcomment">Update Comment</button>
                      @endif
                    </form>
                  @endif
                @else
                  @if (Session::has('username'))
                    @if ($post->posttype == 'Advice')
                      <a href="{{ url()->current() }}?edit={{ $review->reviewID }}" class="btn btn-secondary me-2 btn-outline-advicecomment" style="width:3cm">Edit</a>
                    @else
                      <a href="{{ url()->current() }}?edit={{ $review->reviewID }}" class="btn btn-secondary me-2 btn-outline-assistcomment" style="width:3cm">Edit</a>
                    @endif
                  @endif
                @endif
              </li>
            @endforeach
          </ul>
        @endif
        @if (!Session::has('username'))
          <p class="comment-notice">
            You need to <a href="{{ url('create_user') }}">create a user</a> before commenting.
          </p>
        @endif

        <!-- Comment Form -->
        @if (Session::has('username'))
          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if (session('modified'))
            <div class="alert alert-info">{{ session('modified') }}</div>
          @endif

          @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if ($existingComment)
            <p>You have already commented on this post.</p>
          @elseif(!$userBanned && !$commentsDisabled)
            <h4>Add a Comment</h4>
            <form id="reviewForm" method="POST" action="{{ url('create_review_action/'.$post->postID) }}" class="comment-form">
              {{ csrf_field() }}
              <div class="form-group">
                  <label for="username">Name: {{ Session::get('username') }}</label>
                  <input type="hidden" name="username" value="{{ Session::get('username') }}">
              </div>

              @if ($post->posttype == 'Advice')
                <div class="form-group">
                  <label for="rating">Rating</label>
                  <input type="number" name="rating" class="form-control" id="rating" placeholder="Rate between 1 to 5">
                  <div id="ratingError" class="error-message"></div>
                </div>
              @endif

              <div class="form-group">
                <label for="content">Comment:</label>
                <textarea name="content" class="form-control" rows="3" id="content" required></textarea>
                <div id="contentError" class="error-message"></div>
              </div>
                @if ($post->posttype == 'Advice')
                  <button type="submit" class="btn btn-primary me-2 btn-outline-advicecomment">Submit Comment</button>
                @else
                  <button type="submit" class="btn btn-primary me-2 btn-outline-assistcomment">Submit Comment</button>
                @endif
            </form>
          @endif
        @endif
      </div>
    </div>

  <script>
  document.getElementById("reviewForm").addEventListener("submit", function(event) {
    document.getElementById("ratingError").innerHTML = "";
    document.getElementById("contentError").innerHTML = "";
    var rating = document.getElementById("rating").value;
    var content = document.getElementById("content").value.trim();
    var good = true;
    if (isNaN(rating) || rating < 1 || rating > 5) {
        document.getElementById("ratingError").innerHTML = "Rating must be a number between 1 and 5.";
        good = false;
    }
    var wordCount = content.split(/\s+/).filter(function(word) {
        return word.length > 0;
    }).length;
    if (wordCount < 3) {
        document.getElementById("contentError").innerHTML = "Your review must contain at least 3 words.";
        good = false;
    }
    if (!good) {
        event.preventDefault();
    }
  });
  </script>
@endsection


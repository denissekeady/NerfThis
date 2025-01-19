@extends('layouts.master')

@section('title')
  Create Post
@endsection

@section('background')
    style="background-image: url('images/register_bg.JPEG'); background-repeat: no-repeat; background-size: cover"
@endsection

@section('content')
  <!-- Display Success Message -->
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- Display Username Modification -->
  @if (session('modified'))
    <div class="alert alert-info">
      {{ session('modified') }}
    </div>
  @endif

  <!-- Display Validation Errors -->
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    /div>
  @endif
  
  <div class=container>
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
      <div class="formstyle" style="background-color: rgba(255, 255, 255, 0.8); padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h1 style="text-align: center;">Create Post</h1>
        <form method="post" action="{{url("create_post_action")}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title">
          </div>

          <div class="form-group">
            <label for="platform">Platform</label>
            <select name="platform" class="form-control" id="platform">
              <option>All</option>
              <option>PC</option>
              <option>Playstation</option>
              <option>Xbox</option>
              <option>Nintendo Switch</option>
              <option>Other</option>
            </select>
          </div>

          <div class="form-group">
            <label for="posttype">Post Type</label>
            <select name="posttype" class="form-control" id="posttype">
              <option>Advice</option>
              <option>Assistance</option>
            </select>
          </div>

          <div class="form-group">
            <label for="characterID">Character</label>
            <select name="characterID" id="characterID" class="form-control">
              @foreach($characters as $character)
                <option value="{{ $character->characterID }}">{{ $character->charname }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" id="content" rows="5"></textarea>
          </div>

          <div class="form-group text-center">
            <br>
            <input type="submit" value="Create Post" class="btn btn-primary btn-outline-createpost" type="submit">
          </div>
        </form>
      </div>
    </div><br><br><br>
  </div>
@endsection

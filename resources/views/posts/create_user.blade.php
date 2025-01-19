@extends('layouts.master')

@section('title')
  Create User
@endsection

@section('background')
    style="background-image: url('images/register_bg.JPEG'); background-repeat: no-repeat; background-size: cover"
@endsection

@section('content')
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
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
  <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="formstyle" style="background-color: rgba(255, 255, 255, 0.8); padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
      <h1 style="text-align: center;">Create User</h1>
      <form method="post" action="{{url('create_user_action')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <p>To create a post, you must first create a user.</p>
        <div class="form-group">
          <label for="title">Username</label>
          <input type="text" name="username" class="form-control" id="username">
        </div>

        <div class="form-group">
          <label for="content">Number of Hours</label>
          <input type="text" name="no_of_hrs" class="form-control" id="no_of_hrs">
        </div>

        <div class="form-group text-center">
          <br>
          <input type="submit" value="Create User" class="btn btn-primary btn-outline-createpost" type="submit">
        </div>
      </form>
    </div>
  </div>
@endsection
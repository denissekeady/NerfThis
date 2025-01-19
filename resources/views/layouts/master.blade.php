<!DOCTYPE html>
<html>
<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/wp.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
</head>

<body @section('background') style="background-color:#FFDBE9" @show>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg custom-navbar" style="background: rgba(255, 255, 255, 0.5); background: linear-gradient(to bottom, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('images/dva_logo.png') }}" width="30" height="39" class="d-inline-block align-top" alt="Logo">
        <span class="jersey ms-2">Nerf This</span>
      </a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'nav-link active' : '' }}" aria-current="page" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('advice') ? 'nav-link active' : '' }}" href="{{ url('advice') }}">Advice</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('assistance') ? 'nav-link active' : '' }}" href="{{ url('assistance') }}">Assistance</a>
          </li>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('gamers') ? 'nav-link active' : '' }}" href="{{ url('gamers') }}">Our Gamers</a>
          </li>
        </ul>
        <a class="btn btn-outline-success" href="{{ url('create_post') }}">Create Post</a>
      </div>
    </div>
  </nav>
  <!-- End of Navigation Bar -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+vI1lqDYL24Wck8woELD/h60m26r2" crossorigin="anonymous"></script>

  
  @yield('content')
</body>
</html>

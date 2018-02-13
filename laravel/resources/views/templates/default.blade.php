<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title','Home')</title>

      <link href="/css/bootstrap.min.css" rel="stylesheet">
      <link href="/css/font-awesome.min.css" rel="stylesheet">
      <link href="/css/lightbox.css" rel="stylesheet">
      <link href="/css/app.css" rel="stylesheet">

  </head>

  <body>

  <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="/">IMG GALLERY</a>
      <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
              @if(Auth::check())
                  <li class="nav-item">
                      <a class="nav-link" href="{{route('albums')}}">Albums</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link " href="{{route('album.create')}}">New Album</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link " href="{{route('photos.create')}}">New Image</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link " href="{{route('categories.index')}}">Categories</a>
                  </li>
              @endif
          </ul>

          <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
              <!-- Authentication Links -->
              @if (Auth::guest())
                  <li><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                  <li><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
              @else
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle  nav-link" data-toggle="dropdown" role="button" aria-expanded="false">
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <ul class="dropdown-menu" role="menu">
                          <li>
                              <a href="{{ url('/logout') }}"
                                 onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 Logout
                              </a>

                              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>
                          </li>

                      </ul>
                  </li>
              @endif
          </ul>

      </div>
  </nav>

    <div class="container">
      @yield('content')
    </div>

    @section('footer')

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/js/vendor/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/lightbox.min.js"></script>
    @show
    </body>
</html>
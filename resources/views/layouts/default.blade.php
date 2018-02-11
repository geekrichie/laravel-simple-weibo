<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title','Sample App')-laravel 入门教程</title>
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/demo.css') }}" type="text/css">
  </head>
  <body>
       @include('layouts._header')
    <div class="container" style="padding-top:80px">
      <div class="col-md-offset-1 col-md-10">
      @include('shared._message')
      @yield('content')
      @include('layouts._footer')
    </div>
    </div>
    <script src="/js/app.js" type="text/javascript">

    </script>
  </body>
</html>

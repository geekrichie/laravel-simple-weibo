@extends('layouts.default')
@section('content')
  @if(Auth::check())
  <div class="row">
    <div class="col-md-8">
      <section class="status_form">
        @include('shared._status_form')
      </section>
      <h3>微博列表</h3>
      @include('shared._feed')
    </div>
    <aside class="col-md-4">
      <section class="user_info">
        @include('shared._user_info',[$user=Auth::user()])
      </section>
      <section class="stats">
        @include('shared._stats',[$user=Auth::user()])
      </section>
    </aside>
  </div>
  @else
<div class="jumbotron">
  <h1>Hello Laravel</h1>
  <p>
    你现在看到的是 <a href="https://fsdhub.com/books/laravel-essential-training-5.1"></a>
  </p>
  <p>
    一切，将从这里开始。
  </p>
  <p>
  <a href="{{route('signup')}}" role="button" class="btn btn-lg btn-success" >现在注册</a>
  </p>
</div>
@endif
@stop

@extends('layouts.default')
@section('title', '更新密码')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">更新密码</div>
        <div class="panel-body">
        @if(session('status'))
        <div class="alert alert-success">
          {{session('status')}}
        </div>
        @endif
          <form method="POST" action="{{ route('password.update') }}">
          {{csrf_field()}}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email')?'has-error':''}}">
              <label class=" control-label">邮箱地址：</label>
              <div class="">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                <span class='help-block'>
                  <strong>  {{ $errors->first('email') }} </strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password')?'has-error':''}}">
              <label class="control-label">密码：</label>
              <div class="">
                <input type="password" class="form-control" name="password">
                @if($errors->has('password'))
                <span class='help-block'><strong>
                  {{$errors->first('password')}}
                </strong></span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation')?'has-error':''}}">
              <label class="control-label">确认密码：</label>
              <div>
                <input type="password" class="form-control" name="password_confirmation">
                @if($errors->has('password_confirmation'))
                <span class='help-block'><strong>
                  {{$errors->first('password_confirmation')}}
                </strong></span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="">
                <button type="submit" class="btn btn-primary">
                  修改密码
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@if($user->id!==Auth::user()->id)
<div class="follow_form">
  @if(Auth::user()->isFollowing($user->id))
  <form action="{{route('followers.destroy',$user->id)}}" method="post">
        {{csrf_field()}}
        {{method_field('DELETE')}}
        <button type="submit" class="btn btn-sm follow_form">取消关注</button>
  </form>
  @else
    <form action="{{route('followers.store',$user->id)}}" method="post">
      {{csrf_field()}}
      <button type="submit" class="btn btn-sm btn-primary follow_form">关注</button>
    </form>
    @endif
</div>
@endif

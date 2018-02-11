<form  action="{{route('statuses.store')}}" method="post">
  @include('shared._errors')
  {{csrf_field()}}
  <div>
    <textarea name="content" class="form-control" rows="3" placeholder="聊聊新鲜事儿..."></textarea>
  </div>

  <button type="submit" class="btn btn-primary pull-right">发布</button>
</form>

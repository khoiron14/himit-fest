@if ($message = Session::get('success'))
<div class="alert alert-success" role="alert">
  {{ $message }}
</div>
@elseif ($message = Session::get('warning'))
<div class="alert alert-warning" role="alert">
  {{ $message }}
</div>
@endif
@if ($errors->any())

  <p class="alert alert-danger">
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
  </p>

@endif

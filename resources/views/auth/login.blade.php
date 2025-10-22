@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4>Login</h4>
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ url('login') }}">@csrf
          <div class="mb-3"><label>Email</label><input name="email" class="form-control" /></div>
          <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" /></div>
          <button class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

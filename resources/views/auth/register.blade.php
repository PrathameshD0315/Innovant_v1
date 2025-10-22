@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <h4>Register</h4>
        <form method="POST" action="{{ url('register') }}">@csrf
          <div class="mb-3"><label>Name</label><input name="name" class="form-control" /></div>
          <div class="mb-3"><label>Email</label><input name="email" class="form-control" /></div>
          <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" /></div>
          <div class="mb-3"><label>Confirm Password</label><input type="password" name="password_confirmation" class="form-control" /></div>
          <button class="btn btn-success">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.master')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<section class="no-padding-top no-padding-bottom">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4>{{ Auth::user()->getRoleNames()[0] }} Dashboard</h4>
            <p class="text-muted">You're Logged In</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

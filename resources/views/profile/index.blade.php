@extends('layouts.master')

@section('title', 'Profile Settings')

@section('page-title', 'Profile Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @foreach($errors->all() as $error)
                <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
            @if (session('updated'))
                <li class="alert alert-success">{{ session('updated') }}</li>
            @endif
            <div class="card">
                <div class="card-body">
                    <h4>Settings</h4>
                    <a href="{{ route('home') }}" role="button" class="btn btn-success float-right"><i class="icon-home"></i> Go To Dashboard</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ Auth::user()->name }}" required />
                            </div>
                            <div class="form-group col-md-6">
                              <label for="Email">Email</label>
                              <input type="email" class="form-control" name="email" id="" aria-describedby="emailHelpId" placeholder="Email" value="{{ Auth::user()->email }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="Phone">Phone</label>
                                <input type="phone" class="form-control" name="number" placeholder="Phone Number" value="{{ Auth::user()->number }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ProfileImage">Profile Image</label>
                                <input type="file" class="form-control" name="profile_image" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="submit" class="btn btn-success btn-block" value="Save" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
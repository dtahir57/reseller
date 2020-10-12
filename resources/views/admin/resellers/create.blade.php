@extends('layouts.master')

@section('title', 'Create New Reseller')

@section('page-title', 'Resellers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Create New Seller</h5>
                    <a href="{{ route('admin.reseller.index') }}" role="button" class="btn btn-success float-right">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @foreach($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.reseller.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" placeholder="Name" name="name" required value="{{ old('name') }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" placeholder="Email" name="email" required value="{{ old('email') }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" placeholder="Number" name="number" required value="{{ old('number') }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" placeholder="City" name="city" required value="{{ old('city') }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password" required />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="submit" value="Submit" class="btn btn-primary btn-block" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('title', 'Manage Cities')

@section('page-title', 'Manage Cities')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @foreach($errors->all() as $error)
                <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
            <div class="card">
                <div class="card-body">
                    <h4>Manage Cities</h4>
                    <a href="{{ route('admin.city.index') }}" role="button" class="btn btn-success float-right"><i class="fa fa-th"></i> View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.city.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="city_name" class="form-control" placeholder="City Name" required value="{{ old('city_name') }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="submit" class="btn btn-info btn-block" value="Save" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')

@section('title', 'Resellers')

@section('page-title', 'Resellers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Edit {{ $reseller->email }}</h5>
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
                    <form action="{{ route('admin.reseller.update', $reseller->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" placeholder="Name" name="name" required value="{{ $reseller->name }}" />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" placeholder="Discount" name="discount" value="{{ $reseller->discount }}" />
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
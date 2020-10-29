@extends('layouts.master')

@section('title', 'Resellers')

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
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.reseller.discount') }}" method="POST">
                        @csrf
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" name="discount" placeholder="Give Discount To All Resellers (%)" required value="{{ old('discount') }}" />
                            <input type="submit" class="btn btn-info btn-block mt-4" value="Save" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
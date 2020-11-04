@extends('layouts.master')

@section('title', 'Bank Details')

@section('page-title', 'Bank Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session('created'))
                <li class="alert alert-success">{{ session('created') }}</li>
            @endif
            @if(session('updated'))
                <li class="alert alert-success">{{ session('updated') }}</li>
            @endif
            @if(session('deleted'))
                <li class="alert alert-success">{{ session('deleted') }}</li>
            @endif
            <div class="card">
                <div class="card-body">
                    <h4>Bank Details</h4>
                    @if($bank)
                    <a href="{{ route('bank_detail.edit', $bank->id) }}" role="button" class="btn btn-info float-right"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="{{ route('bank_detail.destroy', $bank->id) }}" role="button" class="btn btn-danger float-right mr-2"><i class="fa fa-trash"></i> Remove</a>
                    @else
                    <a href="{{ route('bank_detail.create') }}" role="button" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Bank</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if($bank)
                        <div class="col-md-3">
                            <h5>Account Title:</h5>
                            <p class="text-info">{{ $bank->account_title }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5>Account Number:</h5>
                            <p class="text-info">{{ $bank->account_number }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5>Bank Name:</h5>
                            <p class="text-info">{{ $bank->bank_name }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5>Phone Number:</h5>
                            <p class="text-info">{{ $bank->phone_number }}</p>
                        </div>
                        <div class="col-md-3">
                            <h5>Email:</h5>
                            <p class="text-info">{{ $bank->email }}</p>
                        </div>
                        @else
                        <div class="col-md-12">
                            <p class="text-muted">No Details Found!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
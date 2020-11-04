@extends('layouts.master')

@section('title', 'Bank Details')

@section('page-title', 'Bank Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Manage Bank Details</h4>
                    <a href="{{ route('bank_detail.index') }}" role="button" class="btn btn-success float-right"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('bank_detail.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="account_title" required placeholder="Account Title" value="{{ old('account_title') }}" />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="account_number" required placeholder="Account Number" value="{{ old('account_number') }}" />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="bank_name" required placeholder="Bank Name" value="{{ old('bank_name') }}" />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number (Optional)" />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Email (Optional)" />
                            </div>
                            <div class="form-group col-md-6">
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
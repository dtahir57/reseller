@extends('layouts.master')

@section('title', 'Discounts')

@section('page-title', 'Discounts')

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
                    <h4>Manage Discounts</h4>
                    <a href="{{ route('admin.discount.create') }}" role="button" class="btn btn-success float-right">Create New</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Reseller</th>
                                    <th>Discount</th>
                                    <th style="width: 200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discount_codes as $code)
                                @php
                                $product = DB::connection('mysql2')->table('wpjo_posts')->where('post_type', 'product')->where('ID', $code->product_id)->first();
                                $user = App\User::find($code->reseller_id);
                                @endphp
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->post_title }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $code->discount }}%</td>
                                    <td>
                                        <a href="{{ route('admin.discount.edit', $code->id) }}" class="btn btn-sm btn-info" role="button">Edit</a>
                                        <a href="{{ route('admin.discount.destroy', $code->id) }}" class="btn btn-sm btn-danger" role="button">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                {!! $discount_codes->render() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
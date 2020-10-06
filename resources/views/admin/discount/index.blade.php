@extends('layouts.master')

@section('title', 'Discounts')

@section('page-title', 'Discounts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
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
                                <th>#</th>
                                <th>Product</th>
                                <th>Reseller</th>
                                <th>Discount</th>
                                <th>Actions</th>
                            </thead>
                        </table>
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
                                <td>
                                    <a href="" class="btn btn-sm btn-primary" role="button">Edit</a>
                                    <a href="" class="btn btn-sm btn-danger" role="button">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {!! $discount_codes->render() !!}
                        </tfoot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
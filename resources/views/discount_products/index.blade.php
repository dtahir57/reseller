@extends('layouts.master')

@section('title', 'Discounted Products')

@section('page-title', 'Discounted Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Title</th>
                                    <th>Discount (&)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discounted_products as $d)
                                    @php
                                        $product = DB::connection('mysql2')->table('wpjo_posts')->where('post_type', 'product')->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $product->post_title }}</td>
                                        <td>{{ $d->discount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
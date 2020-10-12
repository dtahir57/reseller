@extends('layouts.master')

@section('title', 'Products')

@section('page-title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <tr>
                            <th>#</th>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        {{-- <th>Product Description</th> --}}
                        <th>SKU</th>
                        <th>Virtual</th>
                        <th>Downloadable</th>
                        <th>Min Price</th>
                        <th>Max Price</th>
                        <th>On Sale</th>
                        <th>Stock Quantity</th>
                        <th>Stock Status</th>
                        <th>Rating Count</th>
                        <th>Average Rating</th>
                        <th>Total Sales</th>
                        <th>Tax Status</th>
                        <th>Tax Class</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $p)
                        @php
                            $product = DB::connection('mysql2')->table('wpjo_wc_product_meta_lookup')->where('product_id', $p->ID)->first();
                        @endphp
                        @if ($product)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $p->ID }}</td>
                            <td>{{ $p->post_title }}</td>
                            {{-- <td>{!! $p->post_excerpt !!}</td> --}}
                            <td>{{ $product->sku }}</td>
                            <td>
                                @if($product->virtual)
                                    <span class="badge badge-success">YES</span>
                                @else
                                    <span class="badge badge-danger">NO</span>
                                @endif
                            </td>
                            <td>
                                @if($product->downloadable)
                                    <span class="badge badge-success">YES</span>
                                @else
                                    <span class="badge badge-danger">NO</span>
                                @endif
                            </td>
                            <td>{{ $product->min_price }}</td>
                            <td>{{ $product->max_price }}</td>
                            <td>
                                @if($product->onsale)
                                    <span class="badge badge-success">YES</span>
                                @else
                                    <span class="badge badge-danger">NO</span>
                                @endif
                            </td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->stock_status }}</td>
                            <td>{{ $product->rating_count }}</td>
                            <td>{{ $product->average_rating }}</td>
                            <td>{{ $product->total_sales }}</td>
                            <td>{{ $product->tax_status }}</td>
                            <td>{{ $product->tax_class }}</td>
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                      <tfoot>{!! $products->render() !!}</tfoot>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
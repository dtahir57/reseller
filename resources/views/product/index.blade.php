@extends('layouts.master')

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Products</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Products</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>Product ID</th>
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
                      </thead>
                      <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>
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
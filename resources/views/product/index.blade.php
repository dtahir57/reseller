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
                        <th>Max Price</th>
                        {{-- <th>On Sale</th> --}}
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
                            <td>{{ $product->max_price }}</td>
                            {{-- <td>
                                @if($product->onsale)
                                    <span class="badge badge-success">YES</span>
                                @else
                                    <span class="badge badge-danger">NO</span>
                                @endif
                            </td> --}}
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
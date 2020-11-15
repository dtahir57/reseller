@extends('layouts.master')

@section('title', 'Returned Orders')

@section('page-title', 'Returned Orders')

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
                                  <th>Order ID</th>
                                  <th>Customer Name</th>
                                  <th>Total (Rs)</th>
                                  <th>Shipping City</th>
                                  <th>Discount (%)</th>
                                  <th>Discounted Total (Rs)</th>
                                  <th>Status</th>
                                  <th style="width: 200px;">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($returned_orders as $order)
                              @php
                                      $city = App\Models\City::find($order->shipping_city_id);
                                      @endphp
                              <tr>
                                  <td>{{ $loop->index + 1 }}</td>
                                  <td>{{ $order->id }}</td>
                                  <td>{{ $order->customer_name }}</td>
                                  <td>{{ $order->total_price }}</td>
                                  <td>
                                      {{ $city->city_name }}
                                  </td>
                                  <td>
                                      @if ($order->discount)
                                        {{ $order->discount }} %
                                      @else
                                        <p>N/A</p>
                                      @endif
                                  </td>
                                  <td>
                                      @if($order->discounted_price)
                                        {{ $order->discounted_price }}
                                      @else
                                        <p>N/A</p>
                                      @endif
                                  </td>
                                  <td>
                                      <p class="text-info" style="text-transform:uppercase;">{{ $order->status }}</p>
                                  </td>
                                  <td>
                                      <a href="" type="button" class="btn btn-info btn-sm">Edit</a>
                                      <a href="{{ route('order.destroy', $order->id) }}" type="button" class="btn btn-danger btn-sm">Delete</a>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                          <tfoot>{!! $returned_orders->render() !!}</tfoot>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
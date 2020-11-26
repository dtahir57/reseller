@extends('layouts.master')

@section('title', 'Manage Orders')

@section('page-title', 'Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session('created'))
                <li class="alert alert-success">{{ session('created') }}</li>
            @endif
            @if(session('uploaded'))
                <li class="alert alert-success">{{ session('uploaded') }}</li>
            @endif
            @if(session('deleted'))
                <li class="alert alert-success">{{ session('deleted') }}</li>
            @endif
            @foreach($errors->all() as $error)
                <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
            <div class="card">
                <div class="card-body">
                    <h4>Manage Orders</h4>
                    @if(Auth::user()->hasRole('Super_User'))
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#deliveredOrderModal"><i class="fa fa-file"></i> Upload Deliver Orders</button>
                    <button type="button" class="btn btn-danger float-right mr-2" data-toggle="modal" data-target="#returnedOrderModal"><i class="fa fa-file"></i> Upload Retured Orders</button>
                    @endif
                    <a href="{{ route('order.create') }}" role="button" class="btn btn-success float-right mr-2"><i class="fa fa-plus"></i> Create New</a>
                </div>
            </div>
        </div>
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
                              @foreach($orders as $order)
                              @php
                                      $city = App\Models\City::find($order->shipping_city_id);
                                      @endphp
                              <tr>
                                  <td>{{ $loop->index + 1 }}</td>
                                  <td>{{ $order->order_id }}</td>
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
                                      <a href="{{ route('order.destroy', $order->id) }}" role="button" class="btn btn-danger btn-sm">Delete</a>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                          <tfoot>{!! $orders->render() !!}</tfoot>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('orders.partials.deliver_order_modal')
@include('orders.partials.returned_order_modal')
@endsection
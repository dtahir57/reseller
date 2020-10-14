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
            @if(session('deleted'))
                <li class="alert alert-success">{{ session('deleted') }}</li>
            @endif
            <div class="card">
                <div class="card-body">
                    <h4>Manage Orders</h4>
                    <a href="{{ route('order.create') }}" role="button" class="btn btn-success float-right"><i class="fa fa-plus"></i> Create New</a>
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
                                  <th>Discount (%)</th>
                                  <th>Discounted Total (Rs)</th>
                                  <th style="width: 200px;">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($orders as $order)
                              <tr>
                                  <td>{{ $loop->index + 1 }}</td>
                                  <td>{{ $order->id }}</td>
                                  <td>{{ $order->customer_name }}</td>
                                  <td>{{ $order->total_price }}</td>
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
                                      <a href="" type="button" class="btn btn-info btn-sm">Edit</a>
                                      <a href="{{ route('order.destroy', $order->id) }}" type="button" class="btn btn-danger btn-sm">Delete</a>
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
@endsection
@extends('layouts.master')

@section('title', 'Manage Orders')

@section('page-title', 'Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
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
                                  <th>Customer Email</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($orders as $order)
                              <tr>
                                  <td>{{ $loop->index + 1 }}</td>
                                  <td>{{ $order->id }}</td>
                                  <td>{{ $order->billing_first_name }}</td>
                                  <td>{{ $order->billing_email }}</td>
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
@extends('layouts.master')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<section class="no-padding-top no-padding-bottom">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="fa fa-shopping-cart" style="font-size: 40px;"></i></div><strong>Delivered Orders</strong>
            </div>
            <div class="number dashtext-5">{{ $delivered_orders->count() }}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-5"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="fa fa-shopping-cart" style="font-size: 40px;"></i></div><strong>Processing Orders</strong>
            </div>
            <div class="number dashtext-2">{{ $processing_orders->count() }}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="fa fa-shopping-cart" style="font-size: 40px;"></i></div><strong>Returned Orders</strong>
            </div>
            <div class="number dashtext-3">{{ $returned_orders->count() }}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

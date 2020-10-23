@extends('layouts.master')

@section('title', 'View Earnings')

@section('page-title', 'Earnings')

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
                                    <th>Order ID</th>
                                    <th>Total Order Price</th>
                                    <th>Admin Actual Price</th>
                                    <th>Discounted Price</th>
                                    <th>Amount To Be Paid (Actual Profit)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earnings as $earning)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $earning->order_id }} Rs</td>
                                    <td>{{ $earning->order_total }} Rs</td>
                                    <td>{{ $earning->actual_earning }} Rs</td>
                                    <td>
                                        @if ($earning->discounted_total)
                                        {{ $earning->discounted_total }} Rs
                                            @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $earning->actual_profit }} Rs</td>
                                    <td>
                                        @if($earning->status == 'not_paid')
                                        <span class="text-info">NOT PAID</span>
                                        @elseif($earning->status === 'pending')
                                        <span class="text-warning">PENDING</span>
                                        @elseif($earning->status === 'paid')
                                        <span class="text-success">PAID</span>
                                        @endif
                                    </td>
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
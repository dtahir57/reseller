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
                                    <th>Screenshot</th>
                                    <th>Total Order Price</th>
                                    <th>Admin Actual Price</th>
                                    <th>Discounted Price</th>
                                    <th>Amount To Be Paid (Actual Profit)</th>
                                    <th>Total Profit</th>
                                    <th>Status</th>
                                    @if($check === 1)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earnings as $earning)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $earning->order_id }}</td>
                                    @if($earning->screenshot_url)
                                    <td><img src="{{ Storage::url($earning->screenshot_url) }}" alt="Screenshot" width="100" /></td>
                                    @else
                                    <td><span class="text-info">NOT UPLOADED</span></td>
                                    @endif
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
                                        @php
                                            $total_earning = App\Models\Earning::where('reseller_id', $earning->reseller_id)->pluck('actual_profit')->toArray();
                                            $total = array_sum($total_earning);
                                        @endphp
                                        {{ $total }} Rs
                                    </td>
                                    <td>
                                        @if($earning->status == 'not_paid')
                                        <span class="text-info">NOT PAID</span>
                                        @elseif($earning->status === 'pending')
                                        <span class="text-warning">PENDING</span>
                                        @elseif($earning->status === 'paid')
                                        <span class="text-success">PAID</span>
                                        @endif
                                    </td>
                                    @if($check === 1)
                                    <td>
                                        <a href="" role="button" class="btn btn-info">Review On Facebook</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                {!! $earnings->render() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
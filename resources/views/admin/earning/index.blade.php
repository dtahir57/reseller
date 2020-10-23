@extends('layouts.master')

@section('title', 'View Earnings')

@section('page-title', 'Earnings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session('screenshot_uploaded'))
                <li class="alert alert-success">{{ session('screenshot_uploaded') }}</li>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Screenshot</th>
                                    <th>User</th>
                                    <th>Total Order Price</th>
                                    <th>Admin Actual Price</th>
                                    <th>Discounted Price</th>
                                    <th>Amount To Be Paid (Actual Profit)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earnings as $earning)
                                @php
                                    $user = App\User::find($earning->reseller_id);
                                @endphp
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $earning->order_id }} Rs</td>
                                    @if($earning->screenshot_url)
                                    <td><img src="{{ Storage::url($earning->screenshot_url) }}" alt="Screenshot" width="100" /></td>
                                    @else
                                    <td><span class="text-info">NOT UPLOADED</span></td>
                                    @endif
                                    <td>{{ $user->email }}</td>
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
                                    <td>
                                        @if($earning->screenshot_url)
                                            <p class="text-muted">UPLOADED</p>
                                        @else
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#fileModal-{{ $earning->id }}">Attach File</button>
                                        @endif
                                    </td>
                                </tr>
                                @include('admin.earning.file_modal')
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
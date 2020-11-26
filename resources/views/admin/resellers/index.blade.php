@extends('layouts.master')

@section('title', 'Resellers')

@section('page-title', 'Resellers')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          @if (session('discount_added'))
            <li class="alert alert-success">{{ session('discount_added') }}</li>
          @endif
          @if (session('approved'))
            <li class="alert alert-success">{{ session('approved') }}</li>
          @endif
          @if (session('disapproved'))
            <li class="alert alert-success">{{ session('disapproved') }}</li>
          @endif
            <div class="card">
                <div class="card-body">
                    <h4>Manage Resellers</h4>
                    <a href="{{ route('admin.reseller.create') }}" role="button" class="btn btn-success float-right">Create New</a>
                    <a href="{{ route('admin.reseller.create_discount') }}" role="button" class="btn btn-info float-right mr-2">Discount</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if(session('created'))
                <li class="alert alert-success">{{ session('created') }}</li>
            @endif
            @if(session('deleted'))
                <li class="alert alert-success">{{ session('deleted') }}</li>
            @endif
            <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Email
                        </th>
                        <th>Phone Number</th>
                        <th>Discount %</th>
                        <th>Status</th>
                        <th>
                          Actions
                        </th>
                      </thead>
                      <tbody>
                          @foreach($users as $user)
                          <tr>
                              <td>{{ $loop->index + 1 }}</td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->number }}</td>
                              <td>{{ $user->discount }}</td>
                              @if ($user->status === 'approved')
                              <td style="text-transform: uppercase;" class="text-success">{{ $user->status }}</td>
                              @else
                              <td style="text-transform: uppercase;" class="text-info">{{ $user->status }}</td>
                              @endif
                              <td>
                                @if ($user->status === 'pending')
                                  <a href="{{ route('admin.reseller.approve', $user->id) }}" role="button" class="btn btn-success btn-sm">Approve</a>
                                @else
                                  <a href="{{ route('admin.reseller.disapprove', $user->id) }}" role="button" class="btn btn-success btn-sm">Disapprove</a>
                                @endif
                                  <a href="{{ route('admin.reseller.edit', $user->id) }}" role="button" class="btn btn-primary btn-sm">Edit</a>
                                  <a href="{{ route('admin.reseller.destroy', $user->id) }}" role="button" class="btn btn-danger btn-sm">Delete</a>
                                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#bank_details-{{ $user->id }}">Bank Details</button>
                              </td>
                          </tr>
                          @include('admin.resellers.partials.bank_details_modal')
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
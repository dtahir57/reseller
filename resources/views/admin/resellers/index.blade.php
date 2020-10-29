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
                        <th>Discount %</th>
                        <th style="width: 200px;">
                          Actions
                        </th>
                      </thead>
                      <tbody>
                          @foreach($users as $user)
                          <tr>
                              <td>{{ $loop->index + 1 }}</td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->discount }}</td>
                              <td>
                                  <a href="{{ route('admin.reseller.edit', $user->id) }}" role="button" class="btn btn-primary btn-sm">Edit</a>
                                  <a href="{{ route('admin.reseller.destroy', $user->id) }}" role="button" class="btn btn-danger btn-sm">Delete</a>
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
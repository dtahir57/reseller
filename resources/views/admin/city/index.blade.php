@extends('layouts.master')

@section('title', 'Manage Cities')

@section('page-title', 'Manage Cities')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session('created'))
                <li class="alert alert-success">{{ session('created') }}</li>
            @endif
            @if(session('updated'))
                <li class="alert alert-success">{{ session('updated') }}</li>
            @endif
            @if(session('deleted'))
                <li class="alert alert-success">{{ session('deleted') }}</li>
            @endif
            <div class="card">
                <div class="card-body">
                    <h4>Manage Cities</h4>
                    <a href="{{ route('admin.city.create') }}" role="button" class="btn btn-success float-right"><i class="fa fa-plus"></i> New City</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                          <thead class="text-info">
                              <tr>
                                  <th>#</th>
                                  <th>City Name</th>
                                  <th style="width: 200px;">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($cities as $city)
                              <tr>
                                  <td>{{ $loop->index + 1 }}</td>
                                  <td>{{ $city->city_name }}</td>
                                  <td>
                                      <a href="{{ route('admin.city.edit', $city->id) }}" role="button" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                      <a href="{{ route('admin.city.delete', $city->id) }}" role="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                          <tfoot>{!! $cities->render() !!}</tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
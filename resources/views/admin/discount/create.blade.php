@extends('layouts.master')

@section('title', 'New Discount')

@section('styles')
<style>
    ul#List {
        list-style-type: none;
        padding: 0px;
    }

    ul#List li{
        background: #ff8585;
    }

    ul#List li a{
        text-decoration: none;
        display: block;
        color: white;
        padding: 15px;
    }
    ul#List li a:hover {
        background: #302f2f;
        color: #fff;
    }

    #selectedProduct {
        display: none;
    }

    #selectedReseller {
        display: none;
    }
</style>
@endsection

@section('page-title', 'Discounts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session('error'))
                <li class="alert alert-danger">{{ session('error') }}</li>
            @endif
            @foreach($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
            <div class="card">
                <div class="card-body">
                    <h4>Create Discount</h4>
                    <a href="{{ route('admin.discount.index') }}" role="button" class="btn btn-success float-right">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.discount.store') }}" method="POST">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 form-group" id="search_product_div">
                                <input type="text" class="form-control" name="product_title" placeholder="Type Product Title" id="searchProduct" />
                                <div id="products"></div>
                            </div>
                            <div class="col-md-6" id="selectedProduct"></div>
                            <input type="hidden" name="product_id" id="product_id" />
                            <div class="col-md-6 form-group" id="search_reseller_div">
                                <input type="text" class="form-control" name="email" placeholder="Type Reseller Email" id="searchReseller" />
                                <div id="resellers"></div>
                            </div>
                            <div class="col-md-6" id="selectedReseller"></div>
                            <input type="hidden" name="reseller_id" id="reseller_id" />
                            <div class="col-md-6 form-group">
                                <input type="number" class="form-control" name="discount" min=1 placeholder="Discount %" required value="{{ old('discount') }}" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="submit" class="btn btn-primary btn-block" value="Save" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#searchProduct').on('keyup', function () {
            var productVal = $(this).val();
            // if (productVal != '') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin.search_product')}}",
                    type: 'post',
                    data: {product_title: productVal},
                    dataType: 'json',
                    success: function (data) {
                        $("#products").html(data.final);
                    }
                });
            // }
        });

        $('#searchReseller').on('keyup', function () {
            var resellerVal = $(this).val();
            // if (resellerVal != '') {
                $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.search_reseller') }}",
                    type: 'post',
                    data: {email: resellerVal},
                    dataType: 'json',
                    success: function (data) {
                        $('#resellers').html(data.final);
                    }
                });
            // }
        });
    });

    function getProduct(id) {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.get_product') }}",
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#selectedProduct').html(data.final);
                $('#selectedProduct').show();
                $('#search_product_div').hide();
                $('#product_id').val(id);
            }
        });
    }

    function getReseller(id) {
        $.ajax({
            'headers' : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.get_reseller') }}",
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function(data) {
                $('#selectedReseller').html(data.final);
                $('#selectedReseller').show();
                $('#search_reseller_div').hide();
                $('#reseller_id').val(id);
            }
        });
    }

    function search_product() {
        $('#selectedProduct').hide();
        $('#search_product_div').show();
        $('#product_id').removeAttr("value");
    }

    function search_reseller() {
        $('#selectedReseller').hide();
        $('#search_reseller_div').show();
        $('#reseller_id').removeAttr("value");
    }
</script>
@endsection
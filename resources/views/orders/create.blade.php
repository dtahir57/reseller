@extends('layouts.master')

@section('title', 'Create New Order')

@section('page-title', 'Orders')

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

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @foreach($errors->all() as $error)
                <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
            <div class="card">
                <div class="card-body">
                    <h4>Manage Orders</h4>
                    <a href="{{ route('order.index') }}" role="button" class="btn btn-success float-right"><i class="fa fa-th"></i> View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5>Create New Order</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Calculated Order Total: <span id="total_price">0</span>/- Rs </h5>
                                <p><strong>(PLEASE NOTE: This calculated price also includes the discount on any product given by your admin)</strong></p>
                                <input type="hidden" name="total" id="total" value=0 />
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamicField">
                                            <tr id="row1">
                                                <td>
                                                    <div id="product-search-1">
                                                        <input type="text" class="form-control" placeholder="Product Title" name="products[]" id="product1" onkeyup="search_products(1)" />
                                                        <div id="products-1"></div>
                                                    </div>
                                                    <div id="productView1"></div>
                                                    <input type="hidden" name="product_id[]" id="product_id_1" />
                                                    <input type="hidden" name="product_price[]" id="product_price_1" />
                                                    <input type="hidden" name="actual_price[]" id="actual_price_1" />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" id="addMore"><i class="fa fa-plus"></i> Add</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingFirstName">Billing First Name</label>
                                <input type="text" class="form-control" required name="billing_first_name" value="{{ old('billing_first_name') }}" placeholder="Billing First Name" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingLastName">Billing Last Name</label>
                                <input type="text" class="form-control" required name="billing_last_name" value="{{ old('billing_last_name') }}" placeholder="Billing Last Name" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingCompany">Billing Company</label>
                                <input type="text" class="form-control" required name="billing_company" value="{{ old('billing_company') }}" placeholder="Billing Company" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingAddress1">Billing Address 1</label>
                                <input type="text" class="form-control" required name="billing_address_1" value="{{ old('billing_address_1') }}" placeholder="Billing Address 1" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingAddress2">Billing Address 2</label>
                                <input type="text" class="form-control" required name="billing_address_2" value="{{ old('billing_address_2') }}" placeholder="Billing Address 2" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="City">City</label>
                                <input type="text" class="form-control" required name="billing_city" value="{{ old('billing_city') }}" placeholder="City" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="State">State</label>
                                <input type="text" class="form-control" required name="billing_state" value="{{ old('billing_state') }}" placeholder="State" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="PostCode">Post Code</label>
                                <input type="text" class="form-control" required name="billing_postcode" value="{{ old('billing_postcode') }}" placeholder="Post Code" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingCountry">Billing Country</label>
                                <input type="text" class="form-control" required name="billing_country" value="{{ old('billing_country') }}" placeholder="Billing Country" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingEmail">Billing Email</label>
                                <input type="email" class="form-control" required name="billing_email" value="{{ old('billing_email') }}" placeholder="Billing Email" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="BillingPhone">Billing Phone</label>
                                <input type="text" class="form-control" required name="billing_phone" value="{{ old('billing_phone') }}" placeholder="Billing Phone" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="CustomerName">Customer Name</label>
                                <input type="text" class="form-control" required name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer Name" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingFirstName">Shipping First Name</label>
                                <input type="text" class="form-control" required name="shipping_first_name" value="{{ old('shipping_first_name') }}" placeholder="Shipping First Name" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingLastName">Shipping Last Name</label>
                                <input type="text" class="form-control" required name="shipping_last_name" value="{{ old('shipping_last_name') }}" placeholder="Shipping Last Name" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingCompany">Shipping Company</label>
                                <input type="text" class="form-control" required name="shipping_company" value="{{ old('shipping_company') }}" placeholder="Shipping Company" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingAddress1">Shipping Address 1</label>
                                <input type="text" class="form-control" required name="shipping_address_1" value="{{ old('shipping_address_1') }}" placeholder="Shipping Address 1" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingAddress2">Shipping Address 2</label>
                                <input type="text" class="form-control" required name="shipping_address_2" value="{{ old('shipping_address_2') }}" placeholder="Shipping Address 2" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="City">City</label>
                                <input type="text" class="form-control" required name="shipping_city" value="{{ old('shipping_city') }}" placeholder="City" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="State">State</label>
                                <input type="text" class="form-control" required name="shipping_state" value="{{ old('shipping_state') }}" placeholder="State" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="PostCode">Post Code</label>
                                <input type="text" class="form-control" required name="shipping_postcode" value="{{ old('shipping_postcode') }}" placeholder="Post Code" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingCountry">Shipping Country</label>
                                <input type="text" class="form-control" required name="shipping_country" value="{{ old('shipping_country') }}" placeholder="Shipping Country" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingEmail">Shipping Email</label>
                                <input type="email" class="form-control" required name="shipping_email" value="{{ old('shipping_email') }}" placeholder="Shipping Email" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ShippingPhone">Shipping Phone</label>
                                <input type="text" class="form-control" required name="shipping_phone" value="{{ old('shipping_phone') }}" placeholder="Shipping Phone" />
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="Discount">Discount</label>
                                <input type="number" class="form-control" name="discount" placeholder="Discount %" min=1 />
                            </div>
                            <div class="col-md-6 form-group mt-4">
                                <input type="submit" class="btn btn-success btn-block" value="Save" />
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
    function search_products(id) {
        var title = $("#product"+id).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('order.search_products')}}",
            type: 'post',
            data: {title: title, divId: id},
            dataType: 'json',
            success: function (data) {
              $("#products-"+id).html(data.final);
            }
        });
    }
    function getProduct(product_id, divId) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('order.get_product') }}",
            type: 'post',
            data: {id: product_id, divId: divId},
            dataType: 'json',
            success: function (data) {
                $('#productView'+divId).html(data.final);
                $('#product-search-'+divId).hide();
                $('#productView'+divId).show();
                $('#product_id_'+divId).val(data.id);
                $('#product_price_'+divId).val(data.price);
                $('#actual_price_'+divId).val(data.actual_price);
                calculate_price(data.price);
            }
        });
    }
    function search_product_again(id) {
        $('#product-search-'+id).show();
        $('#productView'+id).hide();
        $('#product_id_'+id).removeAttr("value");
        $("#product"+id).val();
        var price = parseInt($('#product_price_'+id).val());
        update_price(price);
    }

    function update_price(price) {
        var total = parseInt($('#total').val());
        var updated_total = total - price;
        $('#total_price').html(updated_total);
        $('#total').val(updated_total);
    }

    function calculate_price(price)
    {
        var total = parseInt($('#total').val());
        if (total > 0) {
            var new_total = parseInt(total) + parseInt(price);
            $('#total_price').html(new_total);
            $('#total').val(new_total);
        } else {
            $('#total_price').html(price);
            $('#total').val(price);
        }
    }
    $(document).ready(function () {
        var i = 1;
        $('#addMore').click(function () {
            i++;
            $('#dynamicField').append('<tr id="row'+i+'"><td><div id="product-search-'+i+'"><input type="text" class="form-control" placeholder="Product Title" name="products[]" id="product'+i+'" onkeyup="search_products('+i+')" /><div id="products-'+i+'"></div></div><div id="productView'+i+'"></div><input type="hidden" name="product_id[]" id="product_id_'+i+'" /><input type="hidden" name="product_price[]" id="product_price_'+i+'" /><input type="hidden" name="actual_price[]" id="actual_price_'+i+'" /></td><td><button type="button" class="btn btn-danger btn-remove" id="'+i+'">X</button></td></tr>');
        });
        $(document).on('click', '.btn-remove', function () {
            var button_id = $(this).attr("id");
            var price = $('#product_price_'+button_id).val();
            update_price(price);
            $("#row"+button_id).remove();
        });
    });
</script>
@endsection
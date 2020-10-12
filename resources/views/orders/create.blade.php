@extends('layouts.master')

@section('title', 'Create New Order')

@section('page-title', 'Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
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
                                                    <input type="text" class="form-control" placeholder="Product Title" name="products[]" id="product1" />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success" id="addMore"><i class="fa fa-plus"></i> Add</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="BillingFirstName">Billing First Name</label>
                                <input type="text" class="form-control" required name="billing_first_name" value="{{ old('billing_first_name') }}" placeholder="Billing First Name" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingLastName">Billing Last Name</label>
                                <input type="text" class="form-control" required name="billing_last_name" value="{{ old('billing_last_name') }}" placeholder="Billing Last Name" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingCompany">Billing Company</label>
                                <input type="text" class="form-control" required name="billing_company" value="{{ old('billing_company') }}" placeholder="Billing Company" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingAddress1">Billing Address 1</label>
                                <input type="text" class="form-control" required name="billing_address_1" value="{{ old('billing_address_1') }}" placeholder="Billing Address 1" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingAddress2">Billing Address 2</label>
                                <input type="text" class="form-control" required name="billing_address_2" value="{{ old('billing_address_2') }}" placeholder="Billing Address 2" />
                            </div>
                            <div class="col-md-6">
                                <label for="City">City</label>
                                <input type="text" class="form-control" required name="billing_city" value="{{ old('billing_city') }}" placeholder="City" />
                            </div>
                            <div class="col-md-6">
                                <label for="State">State</label>
                                <input type="text" class="form-control" required name="billing_state" value="{{ old('billing_state') }}" placeholder="State" />
                            </div>
                            <div class="col-md-6">
                                <label for="PostCode">Post Code</label>
                                <input type="text" class="form-control" required name="billing_post_code" value="{{ old('billing_post_code') }}" placeholder="Post Code" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingCountry">Billing Country</label>
                                <input type="text" class="form-control" required name="billing_country" value="{{ old('billing_country') }}" placeholder="Billing Country" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingEmail">Billing Email</label>
                                <input type="text" class="form-control" required name="billing_email" value="{{ old('billing_email') }}" placeholder="Billing Email" />
                            </div>
                            <div class="col-md-6">
                                <label for="BillingPhone">Billing Phone</label>
                                <input type="text" class="form-control" required name="billing_phone" value="{{ old('billing_phone') }}" placeholder="Billing Phone" />
                            </div>
                            <div class="col-md-6">
                                <label for="CustomerName">Customer Name</label>
                                <input type="text" class="form-control" required name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer Name" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingFirstName">Shipping First Name</label>
                                <input type="text" class="form-control" required name="shipping_first_name" value="{{ old('shipping_first_name') }}" placeholder="Shipping First Name" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingLastName">Shipping Last Name</label>
                                <input type="text" class="form-control" required name="shipping_last_name" value="{{ old('shipping_last_name') }}" placeholder="Shipping Last Name" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingCompany">Shipping Company</label>
                                <input type="text" class="form-control" required name="shipping_company" value="{{ old('shipping_company') }}" placeholder="Shipping Company" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingAddress1">Shipping Address 1</label>
                                <input type="text" class="form-control" required name="shipping_address_1" value="{{ old('shipping_address_1') }}" placeholder="Shipping Address 1" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingAddress2">Shipping Address 2</label>
                                <input type="text" class="form-control" required name="shipping_address_2" value="{{ old('shipping_address_2') }}" placeholder="Shipping Address 2" />
                            </div>
                            <div class="col-md-6">
                                <label for="City">City</label>
                                <input type="text" class="form-control" required name="shipping_city" value="{{ old('shipping_city') }}" placeholder="City" />
                            </div>
                            <div class="col-md-6">
                                <label for="State">State</label>
                                <input type="text" class="form-control" required name="shipping_state" value="{{ old('shipping_state') }}" placeholder="State" />
                            </div>
                            <div class="col-md-6">
                                <label for="PostCode">Post Code</label>
                                <input type="text" class="form-control" required name="shipping_post_code" value="{{ old('shipping_post_code') }}" placeholder="Post Code" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingCountry">Shipping Country</label>
                                <input type="text" class="form-control" required name="shipping_country" value="{{ old('shipping_country') }}" placeholder="Shipping Country" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingEmail">Shipping Email</label>
                                <input type="text" class="form-control" required name="shipping_email" value="{{ old('shipping_email') }}" placeholder="Shipping Email" />
                            </div>
                            <div class="col-md-6">
                                <label for="ShippingPhone">Shipping Phone</label>
                                <input type="text" class="form-control" required name="shipping_phone" value="{{ old('shipping_phone') }}" placeholder="Shipping Phone" />
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
        var i = 1;
        $('#addMore').click(function () {
            i++;
            $('#dynamicField').append('<tr id="row'+i+'"><td><input type="text" class="form-control" placeholder="Product Title" name="products[]" id="product'+i+'" /></td><td><button type="button" class="btn btn-danger btn-remove" id="'+i+'">X</button></td></tr>');
        });
        $(document).on('click', '.btn-remove', function () {
            var button_id = $(this).attr("id");
            $("#row"+button_id).remove();
        });
    });
</script>
@endsection
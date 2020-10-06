@extends('layouts.master')

@section('title', 'New Discount')

@section('page-title', 'Discounts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
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
                    <form action="" method="POST">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="product" placeholder="Search Product" id="searchProduct" />
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="reseller" placeholder="Search Reseller" id="searchReseller" />
                            </div>
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
            // 
        });

        $('#searchReseller').on('keyup', function () {
            var resellerVal = $(this).val();
            // 
        });
    });
</script>
@endsection
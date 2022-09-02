@extends('layouts.master')
@section('content')
<style>
    .card {
        border: none;
        box-shadow: none;
    }

    /*   .table-section {
        height:400px;
    } */
</style>
<div class="card card-design " id="myNav">
    <div class="card-header card-header-section">
        @include('section.salereturnsection')
    </div>
    <div class="card-body">

        <div class="card">
            <div class="card-header">
                @include('section.itemsection')
            </div>
            <div class="card-body">
                <div class="card" style="background-color: #001f3f;">
                    <div class="card-body">
                        <div class="my-custom-scrollbar my-custom-scrollbar-primary scrollbar-morpheus-den table-section" style="background-color:#fff;">
                            @include('invoice.partials.invoiceTable')
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: #001f3f;">
                        @include('creditinvoice.partials.sumsidebarsection')
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@include('salereturn.partials.salereturncreatescript')
@include('section.modelsection')
@endsection
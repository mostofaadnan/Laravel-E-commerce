@extends('layouts.master')


@section('content')
<?php
$setups = \Spatie\Permission\Models\Permission::where('type', 'setup')->get();
$items = \Spatie\Permission\Models\Permission::where('type', 'item')->get();
$suppliers = \Spatie\Permission\Models\Permission::where('type', 'supplier')->get();
$customers = \Spatie\Permission\Models\Permission::where('type', 'customer')->get();
$purchases = \Spatie\Permission\Models\Permission::where('type', 'purchase')->get();
$grns = \Spatie\Permission\Models\Permission::where('type', 'grn')->get();
$purchasepayments = \Spatie\Permission\Models\Permission::where('type', 'purchase_pay')->get();
$credits = \Spatie\Permission\Models\Permission::where('type', 'credit')->get();
$invoices = \Spatie\Permission\Models\Permission::where('type', 'invoice')->get();
$cashdrawer = \Spatie\Permission\Models\Permission::where('type', 'cashdrawer')->get();
$users = \Spatie\Permission\Models\Permission::where('type', 'user')->get();
$roles = \Spatie\Permission\Models\Permission::where('type', 'role')->get();
$transfers = \Spatie\Permission\Models\Permission::where('type', 'transfer')->get();
$vats = \Spatie\Permission\Models\Permission::where('type', 'vat')->get();
$daycloses = \Spatie\Permission\Models\Permission::where('type', 'dayclose')->get();
$salaries = \Spatie\Permission\Models\Permission::where('type', 'salary')->get();
$employes = \Spatie\Permission\Models\Permission::where('type', 'employee')->get();
$accounts = \Spatie\Permission\Models\Permission::where('type', 'account')->get();
$others = \Spatie\Permission\Models\Permission::where('type', 'other')->get();
?>
<style>
    .permistion-pane {
        box-shadow: none;
        height: 200px;
        /*  border:none; */

    }
</style>
<div class="card">
    <div class="card-header card-header-section">@lang('home.new') @lang('home.role')</div>
    <div class="card-body">
        {!! Form::open(array('route' => 'role.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <strong>@lang('home.name'):</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="row">
                    <div class="col-sm-8"><strong>@lang('home.permission'):</strong></div>
                    <div class="col-sm-4 input-group">
                        <label class="mr-1"><input type="checkbox" class="mr-1 mt-2" id="checkall"><b>@lang('home.check') @lang('home.all')</b></label>
                        <input type="text" placeholder="Search" id="search" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.setup')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($setups as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.item')</h5>
                            </div>
                            <div class="card-body">
                                @foreach($items as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.supplier')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($suppliers as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.customer')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($customers as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.purchase')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($purchases as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.purchase') @lang('home.payment')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($purchasepayments as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.credit') @lang('home.payment')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($credits as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.invoice')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($invoices as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.account')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($accounts as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.vat')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($vats as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.employee')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($employes as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.salary')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($salaries as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.other')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($others as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.cash') @lang('home.drawer') @lang('home.and') @lang('home.expenses')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($cashdrawer as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.user')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($users as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card permistion-pane mb-1">
                            <div class="card-header">
                                <h5>@lang('home.role')</h5>
                            </div>
                            <div class="card-body">

                                @foreach($roles as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('home.submit')</button>
        {!! Form::close() !!}
    </div>

</div>

<script>
    $('#checkall').click(function() {
        if ($(this).is(":checked")) {
            $(".name").prop("checked", true);
        } else if ($(this).is(":not(:checked)")) {
            $(".name").prop("checked", false);
        }
    });
</script>



@endsection
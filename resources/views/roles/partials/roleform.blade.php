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
?>
<div class="card">
    <div class="card-header">@lang('home.new') @lang('home.role')</div>
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
                        <label class="mr-1"><input type="checkbox" class="mr-1 mt-2" id="checkall"><b>Check All</b></label>
                        <input type="text" placeholder="@lang('home.search')" id="search" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                </div>


            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('home.submit')</button>
        {!! Form::close() !!}
    </div>
</div>
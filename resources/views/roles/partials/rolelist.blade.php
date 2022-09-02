<div class="card">
    <style .input-group-text{width:auto;}></style>
    <div class="card-header card-header-section">
        <div class="pull-left">
            @lang('home.user') @lang('home.role') @lang('home.management')
        </div>
        <div class="pull-right">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a type="button" class="btn btn-outline-danger" href="{{Route('purchase.create')}}">@lang('home.new') @lang('home.role')</i>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('partials.ErrorMessage')
        <table id="mytable" class="data-table table table-bordered table-sm display" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center"> #@lang('home.sl') </th>
                    <th class="text-center"> @lang('home.id') </th>
                    <th class="text-center"> @lang('home.name') </th>
                    <th class="text-center">@lang('home.status')</th>
                    <th class="text-center">@lang('home.action')</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center"> #@lang('home.sl') </th>
                    <th class="text-center"> @lang('home.id') </th>
                    <th class="text-center"> @lang('home.name') </th>
                    <th class="text-center">@lang('home.status')</th>
                    <th class="text-center">@lang('home.action')</th>
                </tr>
            </tfoot>
        </table>

    </div>


</div>
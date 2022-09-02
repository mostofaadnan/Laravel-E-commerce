<div class="form-row">
    <div class="col-md-5 mb-1">
        <label for="validationDefault02">@lang('home.employee')</label>
        <input type="text" class="form-control" id="search" placeholder="Search" list="employee" autocomplete="off">
        <datalist id="employee">
        </datalist>
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.salary')</label>
        <input type="number" class="form-control" id="salary" placeholder="salary">
    </div>
    <div class="col-md-1 mb-1">
        <label for="validationDefault01">@lang('home.overtime')</label>
        <input type="number" class="form-control" id="overtime" placeholder="Over Time" value="0">
    </div>
    <div class="col-md-1 mb-1">
        <label for="validationDefault01">@lang('home.bonus')</label>
        <input type="number" class="form-control" id="bonus" placeholder="Bonus" value="0">
    </div>
    <div class="col-md-1 mb-1">
        <label for="validationDefault01">@lang('home.reduction')</label>
        <input type="number" class="form-control" id="reduction" placeholder="reduction" value="0">
    </div>
    <div class="col-md-2 mt-4 button-section">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-info" id="addrows" name="button">@lang('home.add')</button>
            <button type="button" id="clear" class="btn btn-sm btn-success" name="button">@lang('home.reset')</button>
        </div>
    </div>
</div>
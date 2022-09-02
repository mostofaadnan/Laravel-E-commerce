<div class="form-row">
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.type')</label>
        <select name="" class="form-control" id="barcodetype">
            <option value="">@lang('home.select')</option>
            @foreach($types as $type)
            <option value="{{ $type->name }}" data-dimension="{{ $type->diemension	}}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1 mb-2">
        <label for="validationDefault01"> @lang('home.dimension')</label>
        <select name="" class="form-control" id="dimensiontype">
        </select>
    </div>
    <div class="col-md-4 mb-1">
        <label for="validationDefault01">@lang('home.company')</label>
        <input type="text" class="form-control" placeholder="Company Name" id="companynames" readonly>
    </div>
    <div class="col-md-4 mb-1">
        <label for="validationDefault01">@lang('home.other') @lang('home.note')</label>
        <input type="text" class="form-control" placeholder="Other Note">
    </div>
    <div class="col-md-1">
        <label for="validationDefault01">@lang('home.setting')</label>
        <button type="button" id="demoview" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#setting">@lang('home.setting')</button>
    </div>
</div>
@include('section.modelsection')
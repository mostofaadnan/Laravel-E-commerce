<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="input-group col-sm-6 mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">@lang('home.company') @lang('home.id')</span>
                </div>
                <input type="text" class="form-control" id="companyid" placeholder="@lang('home.company') @lang('home.id')" disabled>
            </div>
            <div class="input-group col-sm-6 mb-1">
                <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">@lang('home.estd')</span>
                    </div>
                    <input type="text" name="Estd" id="dateinput" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-group  mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">@lang('home.name')</span>
            </div>
            <input type="text" id="name" name="name" class="form-control" placeholder="@lang('home.comapany') @lang('home.name')">
        </div>
        <div class="row">
            <div class="input-group  col-sm-12 mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.country')</label>
                </div>
                <select class="custom-select form-control" name="country_id" id="country">
                    <option selected>@lang('home.select')</option>
                    @foreach($countrys as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">

            <div class="input-group col-sm-6 mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.state')</label>
                </div>
                <select class="form-control" name="state_id" id="state">
                </select>
            </div>
            <div class="input-group col-sm-6 mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.city')</label>
                </div>
                <select class="form-control" name="city_id" id="city">
                </select>
            </div>
        </div>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">@lang('home.address')</label>
            </div>
            <textarea name="address" id="addresstext" class="form-control" cols="30" rows="4" placeholder="@lang('home.address')">
            </textarea>
        </div>
    </div>
    <div class="col-sm-4">
        @include('company.logo')
    </div>
</div>
<div class="row">
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.postal') @lang('home.code')</label>
        </div>
        <input type="text" name="postalcode" class="form-control" id="postalcode" placeholder="@lang('home.postal') @lang('home.code')">
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.tin')</label>
        </div>
        <input type="text" name="tin" class="form-control" id="tin" placeholder="@lang('home.tin')">
    </div>
</div>
<div class="row">
    <div class="input-group col-sm-6 mb-1 ">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.mobile') @lang('home.no')</label>
        </div>
        <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="@lang('home.mobile') @lang('home.no')">
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.phone') @lang('home.no')</label>
        </div>
        <input type="text" name="tell_no" class="form-control" id="tell_no" placeholder="@lang('home.phone') @lang('home.no')">
    </div>
</div>
<div class="row">

    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.fax') @lang('home.no')</label>
        </div>
        <input type="text" name="fax_no" class="form-control" id="fax_no" placeholder="@lang('home.fax') no">
    </div>
    <div class="input-group col-sm-6 mb-1">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">@lang('home.email')</label>
        </div>
        <input type="text" name="email" class="form-control" id="companyemail" placeholder="@lang('home.email')">
    </div>
</div>
<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.website')</label>
    </div>
    <input type="website" name="website" class="form-control" id="website" placeholder="@lang('home.website')">
</div>

<div class="input-group mb-1">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">@lang('home.description')</label>
    </div>
    <textarea name="description" id="description" class="form-control" cols="30" rows="4" placeholder="@lang('home.description')">
                        </textarea>
</div>
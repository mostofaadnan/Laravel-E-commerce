@include('partials.ErrorMessage')
<form action="{{ route('customer.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-sm-6 form-left-portion">
            <div class="input-group  mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">@lang('home.customer') @lang('home.code')</span>
                </div>
                <input type="text" class="form-control" name="customerid" id="customerid" placeholder="@lang('home.customer') @lang('home.id')" readonly>
            </div>
            <div class="input-group  mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">@lang('home.name')</span>
                </div>
                <input type="text" name="customername" id="customername" class="form-control" placeholder="@lang('home.customer') @lang('home.name')">
            </div>
            <div class="input-group  mb-1">
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
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.state')</label>
                </div>
                <select class="custom-select form-control" name="state_id" id="state">
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.city')</label>
                </div>
                <select class="custom-select form-control" name="city_id" id="city">

                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.address')</label>
                </div>
                <textarea name="address" id="addresstext" class="form-control" cols="30" rows="3" placeholder="@lang('home.address')">
              </textarea>
            </div>


            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.status')</label>
                </div>
                <select name="status" class="form-control" id="status">
                    <option value="1">Active</option>
                    <option value="0">inactive</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.mobile') @lang('home.no')</label>
                </div>
                <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="@lang('home.mobile') @lang('home.no')">
            </div>

            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">@lang('home.email') </label>
                </div>
                <input type="text" name="email" class="form-control" id="email" placeholder="@lang('home.email') ">
            </div>
        </div>
        <div class="col-sm-6 form-right-portion">
            <div class="form-group row">
                @include('section.profileupload')
            </div>
        </div>
    </div>

 
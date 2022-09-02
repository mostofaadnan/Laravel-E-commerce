<div class="row">
  <div class="input-group  col-sm-12 mb-1">
    <div class="input-group-prepend">
      <span class="input-group-text">@lang('home.item') @lang('home.id')</span>
    </div>
    <input type="text" class="form-control" id="productid" placeholder="@lang('home.item') @lang('home.id')" readonly>
  </div>

</div>
<div class="input-group  mb-1">
  <div class="input-group-prepend">
    <span class="input-group-text" id="">@lang('home.name')</span>
  </div>
  <input type="text" name="name" id="proname" class="form-control" placeholder="@lang('home.name')">
</div>
<div class="row">
  <div class="input-group  mb-1 col-sm-12">
    <div class="input-group-prepend">
      <label class="input-group-text" for="inputGroupSelect01">@lang('home.category')</label>
    </div>
    <select class="custom-select form-control" name="category" id="category">
      <option value="" selected>@lang('home.select')</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->title }}</option>
      @endforeach
    </select>
  </div>

</div>
<div class="row">
  <div class="input-group mb-1 col-sm-6">
    <div class="input-group-prepend">
      <label class="input-group-text" for="inputGroupSelect01">@lang('home.brand')</label>
    </div>
    <select class="custom-select form-control" name="brand" id="brand">
    </select>
  </div>
  <div class="input-group  mb-1 col-sm-6">
    <div class="input-group-prepend">
      <label class="input-group-text" for="inputGroupSelect01">@lang('home.unit')</label>
    </div>
    <select class="custom-select form-control" name="unit" id="unit">
      <option value="" selected>@lang('home.select')</option>
      @foreach($units as $unit)
      <option value="{{ $unit->id }}">{{ $unit->Shortcut }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="row">
  <div class="input-group mb-1 col-sm-6">
    <div class="input-group-prepend">
      <label class="input-group-text" for="inputGroupSelect01">MRP</label>
    </div>
    <input type="number" class="form-control" name="mrp" id="mrp" value="0" placeholder="MRP">
  </div>
</div>
<div class="row">
  <div class="input-group mb-2 col-sm-6">
    <div class="input-group-prepend">
      <label class="input-group-text" for="inputGroupSelect01">@lang('home.status')</label>
    </div>
    <select name="status" class="form-control" id="status">
      <option value="1">Active</option>
      <option value="0">inactive</option>

    </select>
  </div>
</div>
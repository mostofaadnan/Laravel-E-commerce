@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-8 form-single-input-section">
        <div class="card card-design">
            <div class="card-header card-header-section">
                <div class="row mb-3 mt-2">
                    <div class="col-sm-6">
                        @lang('home.timezone') @lang('home.setup')
                    </div>
                </div>
            </div>
            <div class="card-body form-div">
                <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">@lang('home.general')</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label for="inputGroupSelect01">@lang('home.default') @lang('home.language')</label>
                        </div>
                        <div class="col-sm-6">
                            <select id="language" class="form-control">
                                @foreach($Languages as $language)
                                <option value="{{ $language->short_code }}"> {{ $language->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="container">
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label for="inputGroupSelect01">@lang('home.timezone')</label>
                                </div>
                                <div class="col-sm-6">
                                    <select id="timezone" class="form-control">
                                        @foreach($time_zones as $time_zone)
                                        <option value="{{  $time_zone->name }}">{{ $time_zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                    <button type="submit" id="datainsert" class="btn btn-danger btn-lg"> @lang('home.save') @lang('home.change')</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function CompanyInfromation() {
        $.ajax({
            type: 'get',
            url: "{{ route('company.information') }}",
            dataType: ("json"),
            success: function(data) {
                $("#language option[value='" + data.language + "']").attr('selected', 'selected')
                $("#timezone option[value='" + data.time_zone + "']").attr('selected', 'selected')

            },
        });

    }
    window.onload = CompanyInfromation();


    $("#datainsert").on('click', function() {
        var timezone = $("#timezone").val();
        var language = $("#language").val();

        $.ajax({
            type: 'post',
            url: "{{ route('company.timezoneupdate') }}",
            datatype: 'JSON',
            data: {
                timezone: timezone,
                language: language,
            },
            success: function(data) {
                swal("Succsess", "Timezone & Language Update Successfuly", "success");
                location.reload();
            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Ops! Fail To submit", "Data Submit", "error");
            }
        });

    }); 
</script>

@endsection
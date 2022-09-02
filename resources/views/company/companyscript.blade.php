<script>

$( document ).ready(function() {
    $('#country').change(function() {
        var countryID = $(this).val();
        State(countryID);
    });

    function State(countryID) {
        if (countryID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/State/get-state-list')}}?country_id=" + countryID,
                success: function(res) {
                    if (res) {
                        $("#state").empty();
                        $("#state").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#state").append('<option value="' + key + '">' + value + '</option>');
                        });


                    } else {
                        $("#state").empty();
                    }
                }
            });
        } else {
            $("#state").empty();
            $("#city").empty();
        }
    }
    $('#state').on('change', function() {
        var stateID = $(this).val();
        City(stateID);
    });

    function City(stateID) {
        if (stateID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/City/get-city-list')}}?state_id=" + stateID,
                success: function(res) {
                    if (res) {
                        $("#city").empty();
                        $("#city").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#city").append('<option value="' + key + '">' + value + '</option>');
                        });

                    } else {
                        $("#city").empty();
                    }
                }
            });
        } else {
            $("#city").empty();
        }

    }
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '/' +
        (month < 10 ? '0' : '') + month + '/' +
        (day < 10 ? '0' : '') + day;
    $("#dateinput").val(output);

    function CompanyInfromation() {
        $.ajax({
            type: 'get',
            url: "{{ route('company.information') }}",
            dataType: ("json"),
            success: function(data) {

                loadData(data);

            },
        });

    }
    window.onload = CompanyInfromation();

    function loadData(data) {
        $('#logopreview').attr('src', '');

        if (data.logo !== null) {
            var imagesrc = "{{ asset('storage/app/public/company') }}/" + data.logo;
            $('#logopreview').attr('src', imagesrc);
        }
        var countryid = data.country_id;
        var stateid = data.state_id;
        var cityid = data.city_id;
        FindState(countryid, stateid);
        findCity(stateid, cityid);
        $("#companyid").val(data.id);
        $("#dateinput").val(data.Estd);
        $("#name").val(data.name);
        $("#country option[value='" + countryid + "']").attr('selected', 'selected')
        $("#addresstext").val(data.address);
        $("#postalcode").val(data.postalcode);
        $("#tin").val(data.tin);
        $("#mobile_no").val(data.mobile_no);
        $("#tell_no").val(data.tell_no);
        $("#fax_no").val(data.fax_no);
        $("#companyemail").val(data.companyemail);
        $("#website").val(data.website);
        $("#description").val(data.description);

    }

    //Company Data
    function DataUpdate() {
        $("#overlay").fadeIn();
        var fd = new FormData();
        var files = $('#logo-id')[0].files[0];
        fd.append('file',files);

        var name = $("#name").val();
        var country_id = $("#country").val();
        var state_id = $("#state").val();
        var city_id = $("#city").val();
        var address = $("#addresstext").val();
        var postalcode = $("#postalcode").val();
        var tin = $("#tin").val();
        var status = $("#status").val();
        var mobile_no = $("#mobile_no").val();
        var tell_no = $("#tell_no").val();
        var fax_no = $("#fax_no").val();
        var email = $("#companyemail").val();
        var website = $("#website").val();
        var estd = $("#dateinput").val();
        var description = $("#description").val();
        //var company_image=$("#logo-id").val();
       
        $.ajax({
            type: "POST",
            url: "{{ route('company.update') }}",

            data: {
                name: name,
                country_id: country_id,
                state_id: state_id,
                city_id: city_id,
                address: address,
                postalcode: postalcode,
                tin: tin,
                status: status,
                mobile_no: mobile_no,
                tell_no: tell_no,
                fax_no: fax_no,
                email: email,
                website: website,
                Estd: estd,
                description: description,
                company_image:fd
            },
            cache: false,
            datatype: ("json"),
            success: function(data) {
                $("#overlay").fadeOut();
                swal("Data @lang('home.save')", "Data Submit Successfully", "success");
                CompanyInfromation();

            },
            error: function(data) {
                $("#overlay").fadeOut();
                console.log(data);
                swal("Data Submit", "Ops! Fail To submit", "error");

            }
        });

    }
    $("#datasubmit").click(function() {

        DataUpdate();


    });

    function FindState(countryID, stateid) {
        if (countryID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/State/get-state-list')}}?country_id=" + countryID,
                success: function(res) {
                    if (res) {
                        $("#state").empty();
                        $("#state").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#state").append('<option value="' + key + '">' + value + '</option>');
                        });

                        $("#state option[value='" + stateid + "']").attr('selected', 'selected');
                    } else {
                        $("#state").empty();
                    }
                }
            });
        } else {
            $("#state").empty();
            $("#city").empty();
        }
    }

    function findCity(stateID, cityid) {
        if (stateID) {
            $.ajax({
                type: "GET",
                url: "{{url('Admin/City/get-city-list')}}?state_id=" + stateID,
                success: function(res) {
                    if (res) {
                        $("#city").empty();
                        $("#city").append('<option>Select</option>');
                        $.each(res, function(key, value) {
                            $("#city").append('<option value="' + key + '">' + value + '</option>');
                        });
                        $("#city option[value='" + cityid + "']").attr('selected', 'selected');
                    } else {
                        $("#city").empty();
                    }
                }
            });
        } else {
            $("#city").empty();
        }

    }
});
</script>
<div class="container">
    <div class="hidden">
        <h5 id="msg" style="color: green;">
    </div>
    <div class="form-group">
        <label for="inputGroupSelect01">@lang('home.default') @lang('home.name')</label>
        <select name="" class="form-control" id="vatname">
        </select>

    </div>
    <div class="form-group">
        <label class="" for="inputGroupSelect01">@lang('home.value')</label>
        <input type="text" class="form-control" id="vatvalue" placeholder="@lang('home.value')">
    </div>
</div>
<script>
    function VatList() {
        $.ajax({
            type: 'get',
            url: "{{ route('vatsetting.getlist') }}",
            datatype: 'JSON',
            success: function(data) {
                /*  $("#vlist").html(data);
                 console.log(data) */
                if (data) {
                    $("#vatname").empty();
                    $("#vatname").append('<option value="0">Select</option>');
                    $.each(data, function(key, value) {
                        $("#vatname").append('<option value="' + key + '">' + value + '</option>');
                    });
                } else {
                    $("#vatname").empty();
                }
            },
        });
    }
    window.onload = VatList();
    vatid = 0;
    $('#vatname').change(function() {
        vatid = $(this).val();
        $.ajax({
            type: "get",
            url: "{{ url('Admin/Vatsetting/getview')}}" + '/' + vatid,
            datatype: ("json"),
            success: function(data) {
                if (data == null) {
                    $("#vatvalue").val("");
                } else {
                    $("#vatvalue").val(data.value);
                }

            },
            error: function(data) {

            }

        });
    });

    $(document).on('click', "#vatsubmit", function() {
        var value = $("#vatvalue").val();
        console.log(vatid)
        if (value == "" || value <= 0) {
            swal("Opps! Faild", "Title Value Requird", "error");
        } else {
            if (vatid > 0 || value == "") {
                $.ajax({
                    type: "POST",
                    url: "{{ route('vatsetting.updatevalue') }}",
                    data: {
                        id: vatid,
                        value: value,
                    },
                    datatype: ("json"),
                    success: function() {
                        
                        $("#msg").html("Vat Update Successfully").fadeIn(1000);
                        setTimeout(function(){$("#msg").fadeOut(1000);}, 1500);
                        $("#vatvalue").val("");
                        $("#vatname").val(0);
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    
                });
            }

        }
    });
   
     
</script>
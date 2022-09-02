<script type="text/javascript">
  $(document).ready(function() {
    $('#customersearch').on('keyup', function() {
      var value = $("#customersearch").val();
      if (value == "") {
        $('#customer').html("")
      } else {
        $.ajax({
          type: 'post',
          data: {
            search: value
          },
          url: "{{ route('customer.customerdatalist') }}",
          datatype: 'JSON',
          success: function(data) {
            $('#customer').html(data);
          },
          error: function(data) {}
        });
      }
    });
    // window.onload = customerDataList();
    $('#country').change(function() {
      var countryID = $(this).val();
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
    });
    $('#state').on('change', function() {
      var stateID = $(this).val();
      if (stateID) {
        $.ajax({
          type: "GET",
          url: "{{url('Admin/City/get-city-list')}}?state_id=" + stateID,
          success: function(res) {
            if (res) {
              $("#city").empty();
              $("#state").append('<option>Select</option>');
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
    });

    function customerCode() {
      $.ajax({
        type: 'get',
        url: "{{ route('customer.customercode') }}",
        datatype: 'JSON',
        success: function(data) {
          $("#customerid").val(data);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
    window.onload = customerCode();
  });
</script>
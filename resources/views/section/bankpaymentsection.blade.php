<div class="form-group">
    <label for="formGroupExampleInput">@lang('home.amount')</label>
    <input type="text" class="form-control sum-section" id="bankamount"  placeholder="@lang('home.amount')" readonly>
</div>
<div class="form-group">
    <label for="formGroupExampleInput2">@lang('home.bank')</label>
    <input type="text" class="form-control" id="banknamesearch" placeholder="@lang('home.bank')" list="banknames" autocomplete="off">
    <datalist id="banknames">
    </datalist>
</div>
<div class="form-group">
    <label for="formGroupExampleInput">Acc No</label>
    <input type="text" class="form-control sumsection-input-text" id="accno" placeholder="@lang('home.account') @lang('home.number')">
</div>
<div class="form-group">
    <label for="formGroupExampleInput">@lang('home.remark')</label>
    <textarea name="" id="bankdescrp" cols="35" rows="5" class="form-control sumsection-input-text"></textarea>
</div>
<button style="width:100%;" type="button" id="banksubmittData" class="btn btn-danger btn-lg mt-1" name="button"> @lang('home.submit')<small><i>(cntl+s)</i></small></button>


<script type="text/javascript">

function banknameDataList() {
        $.ajax({
            type: 'get',
            url: "{{ route('bankname.banknamedatalist') }}",
            datatype: 'JSON',
            success: function(data) {
                $('#banknames').html(data);
            },
            error: function(data) {}
        });
    }
 
    window.onload = banknameDataList();
</script>
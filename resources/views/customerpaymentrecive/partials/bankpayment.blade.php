<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">@lang('home.amount')</span>
    </div>
    <input type="text" class="form-control" id="bankamount" placeholder="@lang('home.amount')" readonly>
</div>
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">@lang('home.bank')</span>
    </div>
    <input type="text" class="form-control" id="banknamesearch" placeholder="@lang('home.bank')" list="banknames" required>
    <datalist id="banknames">
    </datalist>
</div>
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">@lang('home.acc') @lang('home.number')</span>
    </div>
    <input type="text" class="form-control sumsection-input-text" id="accno" placeholder="@lang('home.acc')">
</div>
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">@lang('home.description')</span>
    </div>
    <textarea name="" id="bankdescrp" cols="35" rows="3" class="form-control sumsection-input-text"></textarea>
</div>

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
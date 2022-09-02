<div class="form-row">
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.transfer') @lang('home.no')</label>
        <input type="text" class="form-control" id="transfercode" placeholder="@lang('home.transfer') @lang('home.code')" readonly>
    </div>
    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.date')</label>
        <div class="input-group date" data-provide="datepicker" id="datetimepicker2">
            <input type="text" name="openingdate" id="dateinput" class="form-control">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                $('#dateinput').datepicker({
                    format: "yyyy/mm/dd",
                    todayHighlight: true,
                    startDate: today,
                    endDate: end,
                    autoclose: true
                });
                $('#dateinput').datepicker('setDate', today);
            });
        </script>
    </div>
    <div class="col-md-3 mb-1">
        <label for="validationDefault02">@lang('home.from')(@lang('home.branch'))</label>
        <select id="frombranch" class="form-control">
            <option value="{{ Auth::user()->branch_id }}" selected>{{ Auth::user()->BranchName->name }}</option>
        </select>
     
    </div>
    <div class="col-md-3 mb-1">
        <label for="validationDefault02">@lang('home.to')(@lang('home.branch'))</label>
        <input type="text" class="form-control" id="tobranch" placeholder="@lang('home.to')" list="branchone" required>
        <datalist id="branchone">
        </datalist>
    </div>

    <div class="col-md-2 mb-1">
        <label for="validationDefault01">@lang('home.comment')</label>
        <input type="text" class="form-control" placeholder="@lang('home.comment')" id="remark">
    </div>
</div>
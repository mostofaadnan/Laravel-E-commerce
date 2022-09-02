<div class="card inside-card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            Customer Credit Payment
        </div>
        <div class="pull-right">
            <input type="button" value="-" id="credipaybtn" />
        </div>
    </div>
    <div class="card-body" id="creditpayments">
        <table class="table table-sm" id="creditrecieve">
            <thead>
                <tr>
                    <th> #Sl </th>
                    <th> Payment No </th>
                    <th> Payment Date </th>
                    <th> Customer </th>
                    <th> Amount </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> #Sl </th>
                    <th> Payment No </th>
                    <th> Payment Date </th>
                    <th> Customer </th>
                    <th> Amount </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#credipaybtn").click(function() {
            $("#creditpayments").toggle();
        });
    });
</script>
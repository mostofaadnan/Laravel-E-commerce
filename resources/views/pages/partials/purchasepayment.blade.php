<div class="card inside-card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            Supplier Payment
        </div>
        <div class="pull-right">
            <input type="button" value="-" id="spaymentbtn" />
        </div>
    </div>
    <div class="card-body" id="supppayment">
        <table class="table table-sm" id="purchasepaymenttbl">
            <thead>
                <tr>
                    <th> #Sl </th>
                    <th> Payment No </th>
                    <th> Payment Date </th>
                    <th> Supplier </th>
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
                    <th> Supplier </th>
                    <th> Amount </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#spaymentbtn").click(function() {
            $("#supppayment").toggle();
        });
    });
</script>
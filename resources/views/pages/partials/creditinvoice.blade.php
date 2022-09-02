<div class="card inside-card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            Credit Invoice
        </div>
        <div class="pull-right">
            <input type="button" value="-" id="creditinvbtn" />
        </div>
    </div>
    <div class="card-body" id="credit">
        <table class="table table-sm" id="creditinv">
            <thead>
                <tr>
                    <th> #Sl </th>
                    <th> Invoive No </th>
                    <th> Invoice Date </th>
                    <th> Customer </th>
                    <th> Net Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> #Sl </th>
                    <th> Invoive No </th>
                    <th> Invoice Date </th>
                    <th> Customer </th>
                    <th> Net Total</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#creditinvbtn").click(function() {
            $("#credit").toggle();
        });
    });
</script>
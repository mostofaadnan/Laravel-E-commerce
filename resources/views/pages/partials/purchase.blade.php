<div class="card inside-card">
    <div class="card-header card-header-section">
        <div class="pull-left">
           Purchase
        </div>
        <div class="pull-right">
            <input type="button" value="-" id="purchasebtn" />
        </div>
    </div>
    <div class="card-body" id="purchases">
        <table class="table table-sm table-responsive" id="purchasetbl">
            <thead>
                <tr>
                    <th width="10%"> #Sl </th>
                    <th width="10%"> Purchase No </th>
                    <th width="10%"> Purchase Date </th>
                    <th> Supplier </th>
                    <th> Net Total</th>
                    <th width="10%"> Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th width="10%"> #Sl </th>
                    <th width="10%"> Purchase No </th>
                    <th width="10%"> Purchase Date </th>
                    <th> Supplier </th>
                    <th> Net Total</th>
                    <th width="10%"> Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#purchasebtn").click(function() {
            $("#purchases").toggle();
        });
    });
</script>
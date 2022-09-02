<div class="card inside-card">
    <div class="card-header card-header-section">
    <div class="pull-left">
            Expensess
        </div>
        <div class="pull-right">
            <input type="button" value="-" id="expbtn" />
        </div>
    </div>
    <div class="card-body" id="expens">
        <table class="table table-sm" id="expensesstbl">
            <thead>
                <tr>
                    <th> #Sl </th>
                    <th> Expenses No </th>
                    <th> Input Date </th>
                    <th> Title </th>
                    <th> Expenses Type </th>
                    <th> Amount </th>
                </tr>

            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th> #Sl </th>
                    <th> Expenses No </th>
                    <th> Input Date </th>
                    <th> Title </th>
                    <th> Expenses Type </th>
                    <th> Amount </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#expbtn").click(function() {
            $("#expens").toggle();
        });
    });
</script>
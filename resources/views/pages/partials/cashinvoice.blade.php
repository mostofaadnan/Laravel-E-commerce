<div class="card inside-card">
    <div class="card-header card-header-section">
        <div class="pull-left">
            Cash Invoice
        </div>
    <div class="pull-right">
    <input type="button" value="-" id="cashinvbtn"/>
    </div>
    </div>
    <div class="card-body" id="cashinv">
        <table class="table table-sm" id="cinvoice">
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
    $(document).ready(function(){
				$("#cashinvbtn").click(function(){
					$("#cashinv").toggle();
				});
			});
</script>

<script>
  var invoice_api_url = {{$invoicechart ->id}}_api_url;
  var order_api_url = {{ $orderchart ->id}}_api_url;
  var purchase_api_url = {{$purchasechart ->id}}_api_url;
  var suppayment_api_url = {{$SupplierPaymentChart ->id}}_api_url;
  var cuspayment_api_url = {{$CustomerPaymentChart ->id}}_api_url;
  var expenses_api_url = {{$ExpensesChart ->id}}_api_url;

  $(".orderyear").change(function() {
    ChartFileter4();
  });
  $(".charttype4").change(function() {
    ChartFileter4();
  });

  function ChartFileter4() {
    var year = $(".orderyear").val();
    var type = $(".charttype4").val();
     {{$orderchart ->id}}_refresh(order_api_url + "?year=" + year + "&type=" + type);
  }



  $(".invoiceyear").change(function() {
    ChartFileter();
  });
  $(".charttype").change(function() {
    ChartFileter();
  });

  function ChartFileter() {
    var year = $(".invoiceyear").val();
    var type = $(".charttype").val();
     {{$invoicechart->id}}_refresh(invoice_api_url + "?year=" + year + "&type=" + type);
  }


  $(".purchaseyear").change(function() {
    ChartFileter1();
  });
  $(".charttype1").change(function() {
    ChartFileter1();
  });

  function ChartFileter1() {
    var year = $(".purchaseyear").val();
    var type = $(".charttype1").val(); 
    {{$purchasechart -> id}}_refresh(purchase_api_url + "?year=" + year + "&type=" + type);
    }
  
    
    $(".charttype2").change(function() {
    ChartFileter2();
  });
  $(".suppyear").change(function() {
    ChartFileter2();
  });
  function ChartFileter2() {
    var year = $(".suppyear").val();
    var type = $(".charttype2").val(); 
    {{$SupplierPaymentChart -> id}}_refresh(suppayment_api_url + "?year=" + year+ "&type=" + type);
    }


    $(".cuspyear").change(function() {
    ChartFileter3();
  });
  $(".charttype3").change(function() {
    ChartFileter3();
  });
  function ChartFileter3() {
    var year = $(".cuspyear").val();
    var type = $(".charttype3").val(); 
    {{$CustomerPaymentChart -> id}}_refresh(cuspayment_api_url + "?year=" + year+ "&type=" + type);
    }


  
  $(".expyear").change(function() {
   ChartFileter4();
  });
  $(".charttype4").change(function() {
    ChartFileter4();
  });
  function ChartFileter4() {
    var year = $(".expyear").val();
    var type = $(".charttype4").val(); 
    {{$ExpensesChart -> id}}_refresh(expenses_api_url + "?year=" + year+ "&type=" + type);
    }

</script>
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\purchase;
use App\Models\SupplierPayment;
use App\Models\CustomerPaymentRecieve;
use App\Models\Expenses;
use App\Charts\CashInvoiceChart;
use App\Charts\PurchaseChart;
use App\Charts\SupplierPaymentChart;
use App\Charts\CustomerPaymentChart;
use App\Charts\ExpensesChart;
use App\Charts\invoiceMonthlyChart;
use App\Charts\PurchaseChartMonthly;
use App\Charts\SupplierPaymentMonthlyChart;
use App\Charts\CustomerPaymentMonthlychart;
use App\Charts\ExpensesMonthlyChart;
use App\Charts\OrderChart;
use App\Charts\OrderChartMonthly;
use DB;

class ChartMakeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:chart-list', ['only' => [
            'invoice',
            'InvoiceMonthly',
            'purchaseViewYearly',
            'purchaseViewMonthly',
            'supplieyPaymentYearlyView',
            'supplieyPaymentMonthlyView',
            'customerPaymentYearlyView',
            'customerPaymentMonthlyView',
            'ExpensesYearlyChartView',
            'ExpensesMonthlyChartView',
        ]]);
    }
    public function Invoice()
    {
        $apiinvoice = url('Admin/Chart/InvoiceBarchart');
        $invoicechart = new CashInvoiceChart;
        $invoicechart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($apiinvoice);
        return view('chart.invoicechart', compact('invoicechart'));
    }
    public function InvoiceMonthly()
    {
        $apiinvoice = url('Admin/Chart/InvoiceBarchartMonthly');
        $invoicechartmonthly = new invoiceMonthlyChart;
        $invoicechartmonthly->labels(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'])->load($apiinvoice);
        return view('chart.invoicechartmonthly', compact('invoicechartmonthly'));
    }
    public function InvoiceBarchart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $Invoice = Invoice::select(\DB::raw("SUM(nettotal) as sum"), DB::raw("MONTH(created_at) month"))
            ->whereYear('created_at', $year)
            ->where('cancel', 0)
            ->groupBy('month')
            ->get();
        $list = $this->rangeMakeYear(1, 12, $Invoice);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $invoicechart = new CashInvoiceChart;
        $title = "Invoice Chart,Year:" . $year;
        $this->ChartChoice($chartType, $invoicechart, $list, $borderColors, $fillColors, $title);
        return $invoicechart->api();
    }
    public function InvoiceBarchartMonthly(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $month = $request->has('month') ? $request->month : date('m');
        $Invoice = Invoice::select(\DB::raw("SUM(nettotal) as sum"), DB::raw("DAY(created_at) day"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('cancel', 0)
            ->groupBy('day')
            ->get();
        $list = $this->rangeMakeMonth(1, 31, $Invoice);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $invoicechartmonthly = new invoiceMonthlyChart;
        $monthname = date("F", mktime(0, 0, 0, $month, 1));
        $title = "Invoice Chart, Month:" . $monthname . ',Year:' . $year;
        $this->ChartChoice($chartType, $invoicechartmonthly, $list, $borderColors, $fillColors, $title);
        return $invoicechartmonthly->api();
    }
    //Order Chart

    public function Order()
    {
        $apiorder = url('Admin/Chart/OrderBarchart');
        $orderchart = new OrderChart;
        $orderchart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($apiorder);
        return view('chart.orderchart', compact('orderchart'));
    }
    public function OrderMonthly()
    {
        $apiordermontrhly = url('Admin/Chart/OrderBarchartMonthly');
        $OrderChartMonthly = new OrderChartMonthly;
        $OrderChartMonthly->labels(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'])->load($apiordermontrhly);
        return view('chart.orderchartmonthly', compact('OrderChartMonthly'));
    }
    public function OrderBarchart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $purchase = Order::select(\DB::raw("SUM(nettotal) as sum"), DB::raw("MONTH(created_at) month"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();
        $list = $this->rangeMakeYear(1, 12, $purchase);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $OrderChart = new OrderChart;
        $title = "Order Chart,Year:" . $year;
        $this->ChartChoice($chartType, $OrderChart, $list, $borderColors, $fillColors, $title);
        return $OrderChart->api();
    }
    public function OrderBarchartMonthly(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $month = $request->has('month') ? $request->month : date('m');
        $purchase = Order::select(\DB::raw("SUM(nettotal) as sum"), DB::raw("DAY(created_at) day"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->get();
        $list = $this->rangeMakeMonth(1, 31, $purchase);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $OrderChartMonthly = new OrderChartMonthly;
        $monthname = date("F", mktime(0, 0, 0, $month, 1));
        $title = "Order Chart, Month:" . $monthname . ',Year:' . $year;
        $this->ChartChoice($chartType, $OrderChartMonthly, $list, $borderColors, $fillColors, $title);
        return $OrderChartMonthly->api();
    }

    //Purchase charts

    public function purchaseViewYearly()
    {
        $apipurchase = url('Admin/Chart/PurchaseBarchart');
        $purchasechart = new PurchaseChart;
        $purchasechart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($apipurchase);
        return view('chart.purchasechartyearly', compact('purchasechart'));
    }
    public function purchaseViewMonthly()
    {
        $apipurchasemontrhly = url('Admin/Chart/PurchaseBarchartMonthly');
        $purchasechartmonthly = new PurchaseChartMonthly;
        $purchasechartmonthly->labels(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'])->load($apipurchasemontrhly);
        return view('chart.purchasechartmonthly', compact('purchasechartmonthly'));
    }
    public function PurchaseBarchart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $purchase = purchase::select(\DB::raw("SUM(nettotal) as sum"), DB::raw("MONTH(created_at) month"))
            ->whereYear('created_at', $year)
            ->where('status', 1)
            ->groupBy('month')
            ->get();
        $list = $this->rangeMakeYear(1, 12, $purchase);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $purchasechart = new PurchaseChart;
        $title = "Purchase Chart,Year:" . $year;
        $this->ChartChoice($chartType, $purchasechart, $list, $borderColors, $fillColors, $title);
        return $purchasechart->api();
    }
    public function PurchaseBarchartMonthly(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $month = $request->has('month') ? $request->month : date('m');
        $purchase = purchase::select(\DB::raw("SUM(nettotal) as sum"), DB::raw("DAY(created_at) day"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 1)
            ->groupBy('day')
            ->get();
        $list = $this->rangeMakeMonth(1, 31, $purchase);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $PurchaseChartMonthly = new PurchaseChartMonthly;
        $monthname = date("F", mktime(0, 0, 0, $month, 1));
        $title = "purchase Chart, Month:" . $monthname . ',Year:' . $year;
        $this->ChartChoice($chartType, $PurchaseChartMonthly, $list, $borderColors, $fillColors, $title);
        return $PurchaseChartMonthly->api();
    }
    public function supplieyPaymentYearlyView()
    {
        $apiSupplierPaymentChart = url('Admin/Chart/SupplierPaymentChart');
        $SupplierPaymentChart = new SupplierPaymentChart;
        $SupplierPaymentChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($apiSupplierPaymentChart);
        return view('chart.supplierpaymentviewyearly', compact('SupplierPaymentChart'));
    }
    public function supplieyPaymentMonthlyView()
    {
        $apiSupplierPaymentMonthlyChart = url('Chart/SupplierPaymentChartMonthly');
        $SupplierPaymentMonthlyChart = new SupplierPaymentMonthlyChart;
        $SupplierPaymentMonthlyChart->labels(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'])->load($apiSupplierPaymentMonthlyChart);
        return view('chart.SupplierPaymentMonthlyChart', compact('SupplierPaymentMonthlyChart'));
    }
    public function SupplierPaymentChart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $SupplierPayment = SupplierPayment::select(\DB::raw("SUM(payment) as sum"), DB::raw("MONTH(created_at) month"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        $list = $this->rangeMakeYear(1, 12, $SupplierPayment);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $SupplierPaymentChart = new SupplierPaymentChart;
        $title = "Supplier Payment Chart,Year:" . $year;
        $this->ChartChoice($chartType, $SupplierPaymentChart, $list, $borderColors, $fillColors, $title);
        return $SupplierPaymentChart->api();
    }
    public function SupplierPaymentChartMonthly(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $month = $request->has('month') ? $request->month : date('m');
        $SupplierPayment = SupplierPayment::select(\DB::raw("SUM(payment) as sum"), DB::raw("DAY(created_at) day"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->get();
        $list = $this->rangeMakeMonth(1, 31, $SupplierPayment);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $SupplierPaymentMonthlyChart = new SupplierPaymentMonthlyChart;
        $monthname = date("F", mktime(0, 0, 0, $month, 1));
        $title = "Supplier Payment Chart, Month:" . $monthname . ',Year:' . $year;
        $this->ChartChoice($chartType, $SupplierPaymentMonthlyChart, $list, $borderColors, $fillColors, $title);
        return $SupplierPaymentMonthlyChart->api();
    }

    //customer payment Section
    public function customerPaymentYearlyView()
    {
        $apiCustomerPaymentChart = url('Admin/Chart/CustomerPaymentchart');
        $CustomerPaymentChart = new CustomerPaymentChart;
        $CustomerPaymentChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($apiCustomerPaymentChart);
        return view('chart.customerpaymentviewyearly', compact('CustomerPaymentChart'));
    }
    public function customerPaymentMonthlyView()
    {
        $apiCustomerPaymentMonthlyChart = url('Admin/Chart/CustomerPaymentMonthlychart');
        $CustomerPaymentMonthlychart = new CustomerPaymentMonthlychart;
        $CustomerPaymentMonthlychart->labels(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'])->load($apiCustomerPaymentMonthlyChart);
        return view('chart.customerpaymentmonthlychart', compact('CustomerPaymentMonthlychart'));
    }
    public function CustomerPaymentchart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');

        $CustomerPayment = CustomerPaymentRecieve::select(\DB::raw("SUM(recieve) as sum"), DB::raw("Month(created_at) month"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();
        $list = $this->rangeMakeYear(1, 12, $CustomerPayment);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $CustomerPaymentChart = new CustomerPaymentChart;
        $title = "Customer Payment Chart,Year:" . $year;
        $this->ChartChoice($chartType, $CustomerPaymentChart, $list, $borderColors, $fillColors, $title);
        return $CustomerPaymentChart->api();
    }
    public function CustomerPaymentMonthlychart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $month = $request->has('month') ? $request->month : date('m');
        $year = $request->has('year') ? $request->year : date('Y');
        $CustomerPayment = CustomerPaymentRecieve::select(\DB::raw("SUM(recieve) as sum"), DB::raw("DAY(created_at) as day"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->get();
        $list = $this->rangeMakeMonth(1, 31, $CustomerPayment);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $CustomerPaymentMonthlychart = new CustomerPaymentMonthlychart;
        $monthname = date("F", mktime(0, 0, 0, $month, 1));
        $title = "Customer Payment Chart, Month:" . $monthname . ',Year:' . $year;
        $this->ChartChoice($chartType, $CustomerPaymentMonthlychart, $list, $borderColors, $fillColors, $title);
        return $CustomerPaymentMonthlychart->api();
    }
    public function ExpensesYearlyChartView()
    {
        $apiExpensesChart = url('Admin/Chart/ExpensesChart');
        $ExpensesChart = new ExpensesChart;
        $ExpensesChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($apiExpensesChart);
        return view('chart.expensesviewyearly', compact('ExpensesChart'));
    }
    public function ExpensesMonthlyChartView()
    {
        $apiExpensesMonthlyChart = url('Admin/Chart/ExpensesMonthlyChart');
        $ExpensesMonthlyChart = new ExpensesMonthlyChart;
        $ExpensesMonthlyChart->labels(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'])->load($apiExpensesMonthlyChart);
        return view('chart.expensesmonthlychart', compact('ExpensesMonthlyChart'));
    }
    public function ExpensesChart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $year = $request->has('year') ? $request->year : date('Y');
        $Expenses = Expenses::select(\DB::raw("SUM(amount) as sum"), DB::raw("MONTH(created_at) month"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();
        $list = $this->rangeMakeYear(1, 12, $Expenses);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $ExpensesChart = new ExpensesChart;
        $title = "Expenses Chart,Year:" . $year;
        $this->ChartChoice($chartType, $ExpensesChart, $list, $borderColors, $fillColors, $title);
        return $ExpensesChart->api();
    }
    public function ExpensesMonthlyChart(Request $request)
    {
        $chartType = $request->has('type') ? $request->type : 1;
        $month = $request->has('month') ? $request->month : date('m');
        $year = $request->has('year') ? $request->year : date('Y');
        $Expenses = Expenses::select(\DB::raw("SUM(amount) as sum"), DB::raw("DAY(created_at) day"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->get();
        $list = $this->rangeMakeMonth(1, 31, $Expenses);
        $borderColors = $this->BorderColor();
        $fillColors = $this->fillColor();
        $ExpensesMonthlyChart = new ExpensesMonthlyChart;
        $monthname = date("F", mktime(0, 0, 0, $month, 1));
        $title = "Expenses Chart, Month:" . $monthname . ',Year:' . $year;
        $this->ChartChoice($chartType, $ExpensesMonthlyChart, $list, $borderColors, $fillColors, $title);
        return $ExpensesMonthlyChart->api();
    }
    public function ChartChoice($chartType, $chart, $list, $borderColors, $fillColors, $title)
    {
        if ($chartType == 1) {
            $chart->dataset($title, 'bar', $list)
                ->color($borderColors)
                ->backgroundcolor($fillColors);
        } else {
            $chart->dataset($title, 'line', $list)
                ->color("rgb(255, 99, 132)")
                ->backgroundcolor("rgb(255, 99, 132)")
                ->fill(false);
        }
    }

    public function rangeMakeYear($first, $end, $dataset)
    {
        $list = [];
        $month = 'month';
        // loop all 12 month
        foreach (range($first, $end) as $month) {
            $flag = false; // init flag if no month found in montly assessment
            foreach ($dataset as $data) {
                if ($data->month == $month) { // if found add to the list
                    $list[] = $data->sum;
                    $flag = true;
                    break; // break the loop once it found match result
                }
            }

            if (!$flag) {
                $list[] = 0; // if not found, store as 0
            }
        }
        return $list;
    }

    public function rangeMakeMonth($first, $end, $dataset)
    {
        $list = [];
        $month = 'month';
        // loop all 12 month
        foreach (range($first, $end) as $month) {
            $flag = false; // init flag if no month found in montly assessment
            foreach ($dataset as $data) {
                if ($data->day == $month) { // if found add to the list
                    $list[] = $data->sum;
                    $flag = true;
                    break; // break the loop once it found match result
                }
            }

            if (!$flag) {
                $list[] = 0; // if not found, store as 0
            }
        }
        return $list;
    }
    public function BorderColor()
    {
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
        ];
        return $borderColors;
    }
    public function fillColor()
    {
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
        ];
        return $fillColors;
    }
}

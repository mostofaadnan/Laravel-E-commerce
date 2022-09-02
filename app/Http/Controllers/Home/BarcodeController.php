<?php

namespace App\Http\Controllers;

use App\Models\BarcodeType;
use Faker\Provider\Barcode;
use Illuminate\Http\Request;
use App\Models\BarcodeDetails;
use App\Models\BarcodeConfigaration;
use PDF;

class BarcodeController extends Controller
{
  protected $var;

  public function index()
  {
    $types = BarcodeType::select('name', 'diemension')->get();
    return view('barcode.index', compact('types'));
  }
  public function BarCodeConfig()
  {
    $BarCodeConfig = BarcodeConfigaration::where('id', 1)->first();
    return response()->json($BarCodeConfig);
  }
  public function PostData(Request $request)
  {
    $itemcodes = $request->itemcode;
  }
  public function Store(Request $request)
  {
    BarcodeDetails::truncate();
    $tableData = $request->itemtables;
    foreach ($tableData as $items) {
      if ($items['discount'] == "") {
        $discount = 0;
      } else {
        $discount = $items['discount'];
      }
      $BarcodeDetails = new BarcodeDetails();
      $BarcodeDetails->type = $request->barcodetype;
      $BarcodeDetails->dimension = $request->dimension;
      $BarcodeDetails->companyname = $request->companyname;
      $BarcodeDetails->itemcode = $items['code'];
      $BarcodeDetails->itemname = $items['Name'];
      $BarcodeDetails->qty = $items['qty'];
      $BarcodeDetails->mrp = $items['unitprice'];
      $BarcodeDetails->discount = $discount;
      $BarcodeDetails->save();
    }
    $data = "save";
    return response()->json($data);
  }
  public function View()
  {
    $barcodeconfig = BarcodeConfigaration::find(1);
    $BarcodeDetails = BarcodeDetails::orderBy('id', 'asc')->paginate(10);
    return view('barcode.view', compact('BarcodeDetails', 'barcodeconfig'));
  }
  public function PdfView()
  {
    $barcodeconfig = BarcodeConfigaration::find(1);
    $BarcodeDetails = BarcodeDetails::all();
    $pdf = PDF::loadView('barcode.pdfview', compact('BarcodeDetails', 'barcodeconfig'))->setPaper('a4', 'landscape');
    return $pdf->stream('barcode.pdf');
  }
  public function UpdateConfig(Request $request)
  {
    $message = "";
    $barcodeconfig = BarcodeConfigaration::find(1);
    $barcodeconfig->companyshow = $request->companyshow;
    $barcodeconfig->itemcodeshow = $request->itemcodeshow;
    $barcodeconfig->itemnameshow = $request->itemnameshow;
    $barcodeconfig->itempriceshow = $request->itempriceshow;
    $barcodeconfig->itemothernoteshow = $request->itemothernoteshow;
    if ($barcodeconfig->update()) {
      $message = "Successfully Update configaration";
    } else {
      $message = "Fail To Update Configaration";
    }
    return response()->json($message);
  }
}

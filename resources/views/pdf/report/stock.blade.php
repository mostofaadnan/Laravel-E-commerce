@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 ">
                <table width="100%">
                    <tr>
                        <td width="55%"></td>
                        <td>
                            <table class="table table-striped">
                                <tr>
                                    <th align="right">Category:</th>
                                    <td>{{ $data['category'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">Product:</th>
                                    <td>{{ $data['product'] }}</td>
                                </tr>

                            </table>
                        </td>

                    </tr>
                </table>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped" style="width:100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>barcode</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Unit</th>
                            <th>TP</th>
                            <th>MRP</th>
                            <th>Stock Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $netstock=0 ?>
                        @foreach($data['details'] as $key =>$pd)
                        <tr>
                            <?php
                            $openigqty = $pd->openingStock(Auth::user()->branch_id)->sum('qty');
                            $invoice = $pd->QuantityOutBySale(Auth::user()->branch_id)->sum('qty');
                            $invoiceReturn = $pd->QuantityOutBySaleReturn(Auth::user()->branch_id)->sum('qty');
                            $totalinvoiceqty = $invoice - $invoiceReturn;
                            $purchase = $pd->QuantityOutByPurchase(Auth::user()->branch_id)->sum('qty');
                            $PurchaseReturn = $pd->QuantityOutByPurchaseReturn(Auth::user()->branch_id)->sum('qty');
                            $totalPurchaseqty = $purchase - $PurchaseReturn;
                            $stock = $openigqty + ($totalPurchaseqty - $totalinvoiceqty);
                            $mrp = $pd->mrp;
                            $stockamount = $stock * $mrp;
                            $netstock += $stockamount;
                            ?>
                            <td width="5%" align="center">{{ $key+1 }}</td>
                            <td width="10%" align="center">{{ $pd->barcode }}</td>
                            <td>{{ $pd->name }}</td>
                            <td width="15%">{{ $pd->CategoryName->title }}</td>
                            <td width="10%" align="right">{{ $stock }}</td>
                            <td width="10%">{{ $pd->UnitName->Shortcut }}</td>
                            <td width="10%">{{ $pd->tp }}</td>
                            <td width="10%">{{ $pd->mrp  }}</td>
                            <td width="10%">{{ $stockamount  }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="8" align="right">Net Stock</td>
                            <td><b>{{  $netstock }}</b></td>

                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="footer-table" style="margin-top: 60px;" width="100%">
                <tr>
                    <td width="20%">
                        <hr style="border:1px solid #ccc">
                        <p align="center">Prepaid By</p>
                    </td>
                    <td width="60%">
                    </td>
                    <td width="20%">
                        <hr style="border:1px solid #ccc">
                        <p align="center">Director Sign</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
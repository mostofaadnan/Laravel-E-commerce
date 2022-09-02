<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" media="all" />
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 10px;
        }

        .print-slip {
            margin: auto;
        }

        .table {

            top: 0px;
            right: 0px;
            left: 0px;
            bottom: 0px;
        }

        .table th {
            /* height: 5px !important; */
            /*  border: 1px #000 solid !important; */
            padding: 2px !important;
            font-size: 14px;
            /*  text-align:center; */
        }

        .table td {
            /*  height: 5px !important; */
            /*  border: 1px #000 solid !important; */
            font-size: 12px;
            padding: 2px !important;
        }


        .footer-table td {
            font-size: 12px;
        }

        .companydes p {
            line-height: .5;
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .report-head {
            border-bottom: 2px #000 solid;
            border-top: 2px #000 solid;


        }

        header {
            /*   position: fixed; */
            left: 0px;
            right: 0px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            border-top: 1px #000 solid;

        }

        footer p {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            padding: 0px;

        }

        address {
            font-size: 12px;
        }

        .Info-Table td {
            border: none;
            box-shadow: none;
        }

        .table {
            margin: 0px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-5 print-slip">
            <div class="card">
                <div class="card-body">
                    <div class="companydes">
                        <?php $company = \App\Models\Company::where('id', 1)->first(); ?>
                        <h5 align="center">{{ $company->name }} </h5>
                        <p align="center">{{ $company->address }},{{ $company->CityName->name }},{{ $company->StateName->name }},{{ $company->CountryName->name }}</p>
                        <p align="center"><b>Mobile:</b>{{ $company->mobile_no}} </p>
                        <p align="center"><b>Phone:</b>{{ $company->tell_no}}</p>
                        <p align="center"><b>Email:</b>{{ $company->companyemail}}</p>
                        <p align="center"><b>Website:</b>{{ $company->website}}</p>
                    </div>
                    <div class="col-sm-12 report-head">
                        <h6 align="center">{{ $title }}</h6>
                    </div>
                    <table class="table Info-Table" style="width:100%" cellspacing="0">
                        <tr>
                        <tr>
                            <td width="23%"><b>Date:</b></td>
                            <td>{{ $SaleReturn->inputdate }}</td>
                        </tr>
                        <tr>
                            <td width="23%"><b>Return No:</b></td>
                            <td>{{ $SaleReturn->return_no }}</td>
                        </tr>
                        </tr>
                        <tr>
                            <td width="23%"><b>Invoice No:</b></td>
                            <td>{{ $SaleReturn->invoice_id }}</td>
                        </tr>
                        <tr width="23%">
                            <td><b>Customer:</b></td>
                            <td>{{ $SaleReturn->CustomerName->name }}</td>
                        </tr>
                    </table>
                    <table class="table table-striped" style="width:100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th width="8%">Qty</th>
                                <th width="15%">Price</th>
                                <th width="15%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($SaleReturn->returnDetails as $key => $details)
                            <tr>

                                <td>{{ $key+1 }}.{{ $details->productName->name }}</td>
                                <td align="right">{{ $details->qty }}</td>
                                <td align="right">{{ $details->mrp }}</td>
                                <td align="right"> {{ $details->amount }} </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" align="right"><b>Sub Total</b></td>
                                <td align="right">{{ $SaleReturn->amount }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right"><b>Discount</b></td>
                                <td align="right">{{ $SaleReturn->discount }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right"><b>Vat</b></td>
                                <td align="right">{{ $SaleReturn->vat }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right"><b>Return Amount</b></td>
                                <td align="right"> {{ $SaleReturn->nettotal }} </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="footer-table" style="margin-top: 60px;" width="100%">
                        <tr>
                            <td class="border-top">
                                <p align="center">Customer Sign</p>
                            </td>
                            <td></td>
                            <td class="border-top">
                                <p align="center">Prepaid By</p>
                            </td>


                        </tr>
                    </table>
                  
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 100);
        }
    </script>

</body>

</html>
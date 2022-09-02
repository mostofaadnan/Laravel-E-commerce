<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day Close</title>
    <style media="screen">
        page {
            size: A4;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 5px;
        }

        .card-header {
            border: 1px #ccc solid;
            padding: 10px;
            text-align: center;
            font-size: 20px;
            font-style: bold;
            font-family: cursive;
            margin: 10px 0px;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;

        }

        .table th,
        .table td {
            padding: 0.25rem;
            vertical-align: top;
            border: 1px solid #000;
        }

        .table thead th {
            vertical-align: bottom;

        }

        .table tbody+tbody {
            border-top: 1px solid #000;
        }

        .table {
            background-color: #fff;
        }

        .table-Details {
            margin-bottom: 5px;
        }

        .table-Details table {
            width: 100%;

            border-collapse: collapse;
        }

        .table-Details table th,
        .table-Details table td {
            padding: 5px;

        }
    </style>
</head>

<body>
    <div class="container">
        @include('pdf.companydescription')
        <div class="card">
            <div class="card-header">Day Close</div>
            <div class="card-body table-Details">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="10%">#sl</th>
                            <th width="70%">Description</th>
                            <th>Amount</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th>1</th>
                            <th align="left">Date</th>
                            <td align="right">{{ $DayClose->date }}</td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <th align="left">Cash Invoice</th>
                            <td align="right">{{ $DayClose->cashinvoice }}</td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <th align="left">Credit Invoice</th>
                            <td align="right">{{ $DayClose->creditinvoice }}</td>
                        </tr>
                        <tr>
                            <th>4</th>
                            <th align="left">Sale Return</th>
                            <td align="right">{{ $DayClose->salereturn }}</td>
                        </tr>
                        <tr>
                            <th>5</th>
                            <th align="left">Purchase</th>
                            <td align="right">{{ $DayClose->purchase }}</td>
                        </tr>
                        <tr>
                            <th>6</th>
                            <th align="left">GRN</th>
                            <td align="right">{{ $DayClose->grn }}</td>
                        </tr>
                        <tr>
                            <th>7</th>
                            <th align="left">Purchase Return</th>
                            <td align="right">{{ $DayClose->purchasereturn }}</td>
                        </tr>
                        <tr>
                            <th>8</th>
                            <th align="left">Supplier Payment</th>
                            <td align="right">{{ $DayClose->supplierpayment }}</td>
                        </tr>
                        <tr>
                            <th>9</th>
                            <th align="left">Customer Payment Recieve</th>
                            <td align="right">{{ $DayClose->creditpayment }}</td>
                        </tr>
                        <tr>
                            <th>10</th>
                            <th align="left">Expenses</th>
                            <td align="right">{{ $DayClose->expenses }}</td>
                        </tr>
                        <tr>
                            <th>11</th>
                            <th align="left">Cash In</th>
                            <td align="right">{{ $DayClose->cashin }}</td>
                        </tr>
                        <tr>
                            <th>12</th>
                            <th align="left">Cash Out</th>
                            <td align="right">{{ $DayClose->cashout }}</td>
                        </tr>
                        <tr>
                            <th>13</th>
                            <th align="left">Cash Drawer</th>
                            <td align="right">{{ $DayClose->cashdrawer }}</td>
                        </tr>
                        <tr>
                            <th>14</th>
                            <th align="left">Cash In Bank</th>
                            <td align="right">{{ $DayClose->cashinbank }}</td>
                        </tr>
                        <tr>
                            <th>15</th>
                            <th align="left">Stock Amount</th>
                            <td align="right">{{ $DayClose->stockamount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <table style="margin-top: 220px;" width="100%">
                <tr>
                    <td>
                        <hr style="border:1px solid #000">
                        <p align="center">Supplier Sign</p>
                    </td>
                    <td>
                        <hr style="border:1px solid #000">
                        <p align="center">Prepaid By</p>
                    </td>
                    <td>
                        <hr style="border:1px solid #000">
                        <p align="center">Director Sighn</p>
                    </td>
                </tr>

            </table>
        </div>
    </div>

</body>

</html>
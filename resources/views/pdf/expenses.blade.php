@extends('pdf.partials.reportmaster')
@section('content')
<div class="card">
    <div class="card-body">
        <table width="100%">
            <tr>
                <td width="55%"></td>
                <td>
                    <table class="table table-striped">
                        <tr>
                            <th align="right">Expenses No</th>
                            <td>{{ $Expenses->expenses_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">Date</th>
                            <td>{{ $Expenses->inputdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Type</th>
                            <td>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-striped mt-2" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>{{ $Expenses->Exp_Title }}</td>
                    <td>{{ $Expenses->ExpnensesType->name }}</td>
                    <td align="right">{{ $Expenses->amount }}</td>
                    <td>{{ $Expenses->remark }}</td>
                </tr>

            </tbody>
        </table>
        <div class="col-sm-12">
            <table style="margin-top: 60px;" width="100%">
                <tr>
                    <td class="border-top" width="20%">

                        <p align="center">Prepaid By</p>
                    </td>
                    <td width="60%">

                    </td>
                    <td class="border-top" width="20%">
                        <p align="center">Director Sign</p>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    @endsection
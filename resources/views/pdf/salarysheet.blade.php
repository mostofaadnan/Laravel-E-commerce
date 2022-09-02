@extends('pdf.partials.reportmaster')
@section('content')
<style>
    .salary-table td{
        height:50px !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <table width="100%">
            <tr>
                <td width="55%"></td>
                <td>
                    <table class="table table-striped">
                        <tr>
                            <th align="right">Payment No</th>
                            <td>{{ $salary->payment_no }}</td>
                        </tr>
                        <tr>
                            <th align="right">Date</th>
                            <td>{{ $salary->inputdate }}</td>
                        </tr>
                        <tr>
                            <th align="right">From Date</th>
                            <td>{{ $salary->from_date }}</td>
                        </tr>
                        <tr>
                            <th align="right">To Date</th>
                            <td>{{ $salary->to_date }}</td>
                        </tr>
                        <tr>
                            <th align="right">Payment Type</th>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-striped mt-2 salary-table" style="width:100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">#Sl</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Joining Date</th>
                    <th width="5%">Salary</th>
                    <th width="8%">Over Time</th>
                    <th width="8%">Bonus</th>
                    <th width="9%">Reduction</th>
                    <th width="8%">Net Salary</th>
                    <th>Sign</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salary->Details as $key =>$saleryDetails)
                <tr>
                    <td> {{ $key+1 }}</td>
                    <td>{{ $saleryDetails->employeeName->name }}</td>
                    <td>{{ $saleryDetails->employeeName->designation }}</td>
                    <td>{{ $saleryDetails->employeeName->joining_date }}</td>
                    <td align="right">{{ $saleryDetails->salary}}</td>
                    <td align="right">{{ $saleryDetails->	over_time}}</td>
                    <td align="right">{{ $saleryDetails->bonus}}</td>
                    <td align="right">{{ $saleryDetails->reduction}}</td>
                    <td align="right">{{ $saleryDetails->netsalary}}</td>
                    <td></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" align="right"><b>Net Total</b></td>
                    <td align="right"><b>{{ $salary->total_salary }}</b></td>
                    <td align="right"><b>{{ $salary->total_over_time }}</b></td>
                    <td align="right"><b>{{ $salary->total_bonus }}</b></td>
                    <td align="right"><b>{{ $salary->total_reduction }}</b></td>
                    <td align="right"><b>{{ $salary->netsalary }}</b></td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <div class="col-sm-12">
            <table class="footer-table" style="margin-top: 60px;" width="100%">
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
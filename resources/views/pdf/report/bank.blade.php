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
                                    <th align="right">Type</th>
                                    <td>{{ $data['type'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">From</th>
                                    <td>{{ $data['fromdate'] }}</td>
                                </tr>
                                <tr>
                                    <th align="right">To</th>
                                    <td>
                                        {{ $data['todate'] }}
                                    </td>
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
                            <th>Date</th>
                            <th>Type</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0);
                        @foreach($data['details'] as $key =>$pd)
                        <?php
                        $type = '';
                        switch ($pd->type_id) {
                            case 1:
                                $type = 'Cash Invoice';
                                break;
                            case 2:
                                $type = 'Supplier Payment';
                                break;
                            case 3:
                                $type = 'Credit Payment';
                                break;
                            case 5:
                                $type = 'Expenses';
                                break;
                            default:
                                break;
                        }
                        ?>
                        <tr>

                            <td width="5%" align="center">{{ $key+1 }}</td>
                            <td width="10%" lign="center">{{ $pd->inputdate }}</td>
                            <td>{{ $type }}</td>
                            <td align="right" width="12%"><?php echo $pd->cashout == 0 ? '' : $pd->cashout ?></td>
                            <td align="right" width="12%"><?php echo $pd->cashin == 0 ? '' : $pd->cashin ?></td>
                            <td align="right" width="12%">{{ $pd->balance  }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" align="right"><b>Net Total</b></td>
                            <td align="right"><b>{{ $data['details']->sum('cashout') }}</b></td>
                            <td align="right"><b>{{ $data['details']->sum('cashout') }}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="footer-table" style="margin-top: 80px;" width="100%">
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
</div>
@endsection
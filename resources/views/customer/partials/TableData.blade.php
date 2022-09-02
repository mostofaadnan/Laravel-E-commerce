@include('partials.ErrorMessage')
<table class="table table-striped table-responsive" style="width:100%">
    <thead">
        <tr>
            <th> #@lang('home.sl')  </th>
            <th> @lang('home.id')  </th>
            <th> @lang('home.name')  </th>
            <th> @lang('home.phone')  </th>
            <th> Opening Balance </th>
            <th> Credit Invoice</th>
            <th> Cash Invoice </th>
            <th> Tota Consighment </th>
            <th>Payment</th>
            <th>Balance Due</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $i++ }}
            </td>
            <td>{{  $customer->id }}</td>
            <td>{{  $customer->name }}</td>
            <td>{{  $customer->TIN }}</td>
            <td>{{ $customer->openingBalance }}</td>
            <td>{{ $customer->credit }}</td>
            <td>{{ $customer->cash }}</td>
            <td>{{ $customer->consignment }} </td>
            <td>{{ $customer->payment }}</td>
            <td>{{ $customer->balancedue }}</td>
            <td>
                <?php
                if ($customer->status == 0) { ?>
                    <button class="btn btn-danger" id="active" data-id="{{ $customer->id}}">Inactive</button>
                <?php  } else {  ?>
                    <button class="btn btn-info" id="inactive" data-id="{{ $customer->id}}">Active</button>
                <?php } ?>
            </td>
            <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a type="button" class="btn btn-info" href="{{route('customer.show', $customer->id )}}"><i class="fa fa-eye" style="color:#fff"></i></a>
                    <a type="button" class="btn btn-primary" href="{{route('supplier.edit', $customer->id )}}"><i class="fa fa-edit" style="color:#fff"></i></a>
                    <a type="button" class="btn btn-danger" id="deletedata" data-id="{{ $customer->id}}"><i class="fa fa-trash" style="color:#fff"></i></a>
                    <!--  <a type="button" class="btn btn-primary" href="{{route('supplier.delete', $customer->id )}}"><i class="fa fa-edit" style="color:#fff"></i></a> -->
                </div>
            </td>
        </tr>
        @endforeach

        
    </tbody>
</table>
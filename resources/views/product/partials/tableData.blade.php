<?php $i = 1; ?>
@foreach($products as $product)
<tr>
    <td align="center">{{ $i++ }}
    </td>
    <td align="left">{{ $product->id }}</td>
    <td align="left">{{ $product->barcode }}</td>
    <td align="left">{{ $product->name }}</td>
    <td align="left">{{ $product->CategoryName->title}}</td>
    <td align="left">{{ $product->SubcategoryName->title}}</td>
    <td align="left">{{ $product->BrandName->title}} </td>
    <td align="right" <?php $product->qty <= 0 ? 'style="color:red;"' : 'style="color:black;"' ?>>{{ $product->qty }}</td>
    <td align="left">{{ $product->UnitName->Shortcut }}</td>
    <td align="right">{{$product->tp}}</td>
    <td align="right">{{$product->mrp}}</td>
    <td>
        <?php

        if ($product->status == 0) { ?>
            <button class="btn btn-danger" id="active" data-id="{{ $product->id}}">Inactive</button>

        <?php  } else {  ?>

            <button class="btn btn-info" id="inactive" data-id="{{ $product->id}}">Active</button>

        <?php } ?>
    </td>
    <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a type="button" class="btn btn-outline-primary btn-sm" href="{{route('product.show', $product->id )}}">View</a>
            <a type="button" class="btn btn-outline-success btn-sm" href="{{route('product.edit', $product->id)}}">Edit</a>
            <a type="button" class="btn btn-outline-danger btn-sm" id="deletedata" data-id="{{ $product->id}}">Delete</a>
            <!--  <a type="button" class="btn btn-primary" href="{{route('supplier.delete', $product->id )}}"><i class="fa fa-edit" style="color:#fff"></i></a> -->
        </div>
    </td>
</tr>
@endforeach
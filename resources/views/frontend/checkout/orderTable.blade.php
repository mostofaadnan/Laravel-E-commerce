<div class="order_table table-responsive">

    <table class="datatable" id="table" >
        <thead>
            <tr>
                <th>Product</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody class="datat">
            @foreach($products as $id=>$product)
            <tr data-itemcode="{{ $product['item']['id'] }}" data-name="{{ $product['item']['name'] }}" data-qty="{{ $product['qty'] }}" data-unitprice="{{ $product['unitprice'] }}"   data-amount="{{ $product['price'] }}" data-color="{{ $product['color']}}" data-size="{{ $product['size'] }}">
                <td style="text-align:left;">{{ $product['item']['name'] }} <strong> × {{ $product['qty'] }}</strong></td>
                <td> TK {{ $product['price'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Subtotal</th>
                <td>TK <span id="amount">{{ $totalprice }}</span></td>
            </tr>
            <tr>
                <th>Shipping</th>
                <td><strong>Tk <span id="shiping">{{ $shipment }}</span></strong></td>
            </tr>
            <tr class="order_total">
                <th>Net Total</th>
                <td><strong>TK <span id="nettotal">{{ $netotal }}</span></strong></td>
            </tr>
        </tfoot>
    </table>
</div>
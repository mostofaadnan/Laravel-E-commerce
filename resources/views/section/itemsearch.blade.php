<style>
    .dataTables_filter {
        float: left !important;
    }
</style>
<div class="container">
    <table id="mytable" class="table table-bordered" style="width:100%" cellspacing="0">
        <thead>
            <tr>
                <th> #@lang('home.sl') </th>
                <th> @lang('home.barcode')</th>
                <th> @lang('home.name') </th>
                <th>@lang('home.stock')</th>
                <th>@lang('home.stock') @lang('home.unit')</th>
                <th>@lang('home.tp')</th>
                <th>@lang('home.mrp')</th>
                <th>@lang('home.discount')</th>

            </tr>
        </thead>
        <tbody id="tablebody">
        </tbody>
        <tfoot>
            <tr>
                <th> #@lang('home.sl') </th>
                <th> @lang('home.barcode')</th>
                <th> @lang('home.name') </th>
                <th>@lang('home.stock')</th>
                <th>@lang('home.stock') @lang('home.unit')</th>
                <th>@lang('home.tp')</th>
                <th>@lang('home.mrp')</th>
                <th>@lang('home.discount')</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    var table;

    function DataTable() {
        table = $('#mytable').DataTable({
            responsive: true,
            paging: false,
            scrollY: 400,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            stateSave: true,
            processing: false,
            serverSide: true,
            language: {
                "search": "_INPUT_", // Removes the 'Search' field label
                "searchPlaceholder": "Search" // Placeholder for the search box
            },
            search: {
                "addClass": 'form-control pull-left input-lg col-xs-12'
            },

            fnDrawCallback: function() {
                $("input[type='search']").attr("id", "searchBox");
                $('#dialPlanListTable').css('cssText', "margin-top: 0px !important;");
                $("select[name='dialPlanListTable_length'], #searchBox").removeClass("input-sm");
                $('#searchBox').css("width", "300px").focus();
                $('#dialPlanListTable_filter').removeClass('dataTables_filter');
            },
            deferLoading: [0, 100],
            /*  dom: '<"top"f>rt<"bottom"lp><"clear">', */
            dom: "<'row'<'col-sm-12'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "ajax": {
                "url": "{{ route('stock.loadall') }}",
                "type": "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: "text-center"
                },

                {
                    data: 'barcode',
                    name: 'barcode',


                },
                {
                    data: 'name',
                    name: 'name',

                },

                {
                    data: 'stock',
                    name: 'stock',
                    className: "text-right bold"
                },
                {
                    data: 'unit',
                    name: 'unit',

                },
                {
                    data: 'tp',
                    name: 'tp',
                    className: "text-right"
                },
                {
                    data: 'mrp',
                    name: 'mrp',
                    className: "text-right"
                },
                {
                    data: 'discount',
                    name: 'discount',
                    className: "text-right"
                },
            ],

        });
        $('.dataTables_length').addClass('bs-select');

    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
            .responsive.recalc();
    });
    window.onload = DataTable();
</script>
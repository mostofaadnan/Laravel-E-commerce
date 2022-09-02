<link rel="stylesheet" href="{{asset('assets/css/custom/productGird.css')}}">
<style>
    .single-product {
        margin: auto;
    }
</style>

<div class="container-fluid mt-3 mb-3">
    <div class="card-header profile-view">
        <div class="row">
            <div class="col-sm-6 col-md-6">

            </div>
            <div class="col-sm-6 col-md-6">
                <div class="input-group  mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">@lang('home.search')</span>
                    </div>
                    <input type="text" class="form-control" id="search" placeholder="Search" list="product" required>
                    <datalist id="product">
                    </datalist>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-2">
        <div id="products">

        </div>
    </div>
</div>



<div class="container">
    <div class="row">

    </div>

    <div id="pager" style="margin-top:20px;float:right;">
        <nav aria-label="Page navigation example">
            <ul id="pagination" class="pagination"></ul>
        </nav>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var $pagination = $('#pagination'),
            totalRecords = 0,
            records = [],
            displayRecords = [],
            recPerPage = 16,
            page = 1,
            totalPages = 0;

        function ItemDatalist() {
            $.ajax({
                type: 'get',
                url: "{{ route('product.itemdatalist') }}",
                datatype: 'JSON',
                success: function(data) {
                    $('#product').html(data);
                },
                error: function(data) {}
            });
        }
        window.onload = ItemDatalist();

        $("#search").on('input', function() {
            var val = this.value;

            if ($('#product option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                productid = $('#product').find('option[value="' + val + '"]').attr('id');
                $.ajax({
                    type: 'post',
                    url: "{{ url('Admin/Session-Id/productId')}}" + '/' + productid,
                    success: function() {
                        ItemInformation();
                    }
                });

            }

        });


        function ItemInformation() {
            $.ajax({
                type: 'get',
                url: "{{ route('product.getDataById') }}",
                datatype: 'JSON',
                success: function(data) {
                    $('#products').empty();

                    LoadData(data)
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function LoadData(data) {
            var html;
            $('#products').html('');
            var imagesrc;
            $('#product-profile').attr('src', '');
            if (data.image !== null) {
                imagesrc = "{{ asset('storage/app/public/product/image/profile') }}/" + data.image;
                $('#product-profile').attr('src', imagesrc);
            }
            var link = '{{ route("product.productdetails", ":id") }}';
            link = link.replace(':id', data.id);
            html = '<div class="col-md-12 single-product">' +
                '<div class="card product-card">' +
                '<a id="datashow" data-id="' + data.id + '"><div class="img-container">' +
                '<img src="' + imagesrc + '" class="img-fluid">' +
                '</div></a>' +
                '<div class="product-detail-container">' +
                '<div class="justify-content-between align-items-center">' +
                '<a href="#" class="datashow" data-id="' + data.id + '"><h6 class="mb-0">' + data.name + '</h6></a>' +
                '<span class="text-danger font-weight-bold">Tk ' + data.mrp + '</span>' +
                '</div>' +
                '<div class="mt-3 mb-2 btn-grp"> <div class="btn-group" role="group" aria-label="Basic example"><button class="btn btn-danger datashow"  data-id="' + data.id + '">View</button><button class="btn btn-danger" class="btn btn-danger dataedit" data-id="' + displayRecords[i].id + '">Edit</button><button class="btn btn-danger datadelete" data-id="' + data.id + '">Delete</button></div> </div>' +
                '</div></div></div>'

            $('#products').append(html);

        }

        function allData() {
            $.ajax({
                type: 'get',
                url: "{{ route('product.allproduct') }}",
                dataType: 'json',
                success: function(data) {
                    records = data;
                    totalRecords = records.length;
                    totalPages = Math.ceil(totalRecords / recPerPage);
                    apply_pagination();
                }
            });
        }
        window.onload = allData();

        function generate_table() {
            var html;
            $('#products').html('');
            for (var i = 0; i < displayRecords.length; i++) {
                var imagesrc;
                $('#product-profile').attr('src', '');
                if (displayRecords[i].image !== null) {
                    imagesrc = "{{ asset('storage/app/public/product/image/profile') }}/" + displayRecords[i].image;
                    $('#product-profile').attr('src', imagesrc);
                }
                var link = '{{ route("product.productdetails", ":id") }}';
                link = link.replace(':id', displayRecords[i].id);

                html = '<div class="col-md-3">' +
                    '<div class="card product-card">' +
                    '<a id="datashow" data-id="' + displayRecords[i].id + '"><div class="img-container">' +
                    '<img src="' + imagesrc + '" class="img-fluid">' +
                    '</div></a>' +
                    '<div class="product-detail-container">' +
                    '<div class="justify-content-between align-items-center">' +
                    '<a href="#" class="datashow" data-id="' + displayRecords[i].id + '"><h6 class="mb-0">' + displayRecords[i].name + '</h6></a>' +
                    '<span class="text-danger font-weight-bold">Tk ' + displayRecords[i].mrp + '</span>' +
                    '</div>' +
                    '<div class="mt-3 mb-2 btn-grp"> <div class="btn-group" role="group" aria-label="Basic example"><button class="btn btn-danger datashow"  data-id="' + displayRecords[i].id + '">View</button><button class="btn btn-danger dataedit" data-id="' + displayRecords[i].id + '">Edit</button><button class="btn btn-danger datadelete" data-id="' + displayRecords[i].id + '">Delete</button></div> </div>' +
                    '</div></div></div>'

                $('#products').append(html);

            }
        }

        function apply_pagination() {
            $pagination.twbsPagination({
                totalPages: totalPages,
                visiblePages: 6,
                onPageClick: function(event, page) {
                    displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                    endRec = (displayRecordsIndex) + recPerPage;
                    displayRecords = records.slice(displayRecordsIndex, endRec);
                    generate_table();
                }
            });
        }


        $(document).on('click', ".datashow", function() {
            var dataid = $(this).data("id");
            url = "{{ url('Admin/Product/productDetails')}}" + '/' + dataid,
                window.location = url;
        });
        $(document).on('click', ".dataedit", function() {
            var dataid = $(this).data("id");
            url = "{{ url('Admin/Product/edit')}}" + '/' + dataid,
                window.location = url;
        });

        $(document).on('click', '.datadelete', function() {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this  data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var dataid = $(this).data("id");
                        $.ajax({
                            type: "post",
                            url: "{{ url('Admin/Product/delete')}}" + '/' + dataid,
                            success: function(data) {
                                allData();
                            },
                            error: function() {
                                swal("Opps! Faild", "Form Submited Faild", "error");

                            }
                        });

                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });


        });

    });
</script>
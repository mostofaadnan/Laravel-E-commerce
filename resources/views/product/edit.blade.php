@extends('layouts.master')
@section('content')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .btn-group {
        border: none;
    }
</style>
<div class="row">
    <div class="col-sm-10 form-single-input-section">
        <div class="card card-design">
            <div class="card-header card-header-section">
                <div class="row mb-3 mt-2">
                    <div class="col-sm-6">
                        @lang('home.edit') @lang('home.item')
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="search" placeholder=" @lang('home.search')" list="product" autocomplete="off">
                        <datalist id="product">
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="card-body form-div">
                <div class="container">
                    @include('partials.ErrorMessage')

                    @csrf
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                @include('product.partials.inputForm')
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-left: auto;margin-right: auto;">
                            @include('product.partials.profilePicture')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            @include('product.partials.texteditor')
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            @include('product.partials.multipleImageUpload')
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer  card-footer-section">
                <div class="pull-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="submit" id="datainsert" class="btn btn-success btn-lg"> @lang('home.submit')</button>
                        <button id="reset" class="btn btn-light clear_field btn-lg"> @lang('home.reset')</button>
                        <button id="deletedata" class="btn btn-danger btn-lg"> @lang('home.delete')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var num = 1;
        var MultiImage = [];
        var dataid;
        var multiImagearr;
        var profileImage;
        var json_arr = "";
        /*    tinymce.init({
               selector: 'textarea',
               plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
               toolbar_mode: 'floating',
           }); */
        var objArray = [];
        tinymce.init({
            selector: 'textarea',
            toolbar_mode: 'floating',
            height: 250,
            templates: objArray
        });

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
            var mrp = 0;
            if ($('#product option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                itemids = $('#product').find('option[value="' + val + '"]').attr('id');
                itemDetails(itemids);

            }
        });

        $('#category').change(function() {
            var categoryid = $(this).val();
            if (categoryid) {
                $.ajax({
                    type: "GET",
                    url: "{{url('Admin/Product/get-subcategory-list')}}?category_id=" + categoryid,
                    success: function(res) {
                        if (res) {
                            $("#subcategory").empty();
                            $("#subcategory").append('<option>Select</option>');
                            $.each(res, function(key, value) {
                                $("#subcategory").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#subcategory").empty();
                        }
                    }
                });
            } else {
                $("#subcategory").empty();

            }
        });


        $('#category').change(function() {
            var categoryid = $(this).val();
            if (categoryid) {
                $.ajax({
                    type: "GET",
                    url: "{{url('Admin/Product/get-Brand-list')}}?category_id=" + categoryid,
                    success: function(data) {
                        if (data) {
                            $("#brand").empty();
                            $("#brand").append('<option>Select</option>');
                            $.each(data, function(index, value) {
                                $("#brand").append('<option value="' + value.brand_name['id'] + '">' + value.brand_name['title'] + '</option>');
                            });
                        } else {
                            $("#brand").empty();
                        }
                    }
                });
            } else {
                $("#brand").empty();

            }
        });

        //$("#adddata").on("submit", function(e) {
        $("#datainsert").on("click", function(e) {
            upload();
        });

        function InsertData(json_arrs) {
            var MultiImages = {};
            var colorlist = new Array();
            var color = {};
            color = $("#mulitcolor").val();
            var sizelist = new Array();
            var size = {};
            size = $("#multisize").val();
            var name = $("#name").val();
            var description = tinymce.get("description").getContent();
            var category_id = $("#category").val();
            var subcategory_id = $("#subcategory").val();
            var brand_id = $("#brand").val();
            var unit_id = $("#unit").val();
            var tp = $("#tp").val();
            var mrp = $("#mrp").val();
            var status = $("#status").val();
            var dataid = "{{ $id }}";
            if (name == "" || category_id == "" || unit_id == "" || tp == 0 || mrp == "") {
                swal("Opps! Faild", "Requirment Field Error", "error");
            } else {
                //   ProfileUpload();
                $("#overlay").fadeIn();
                $.ajax({
                    url: "{{ route('product.dataUpdate') }} ",
                    type: 'POST',
                    data: {
                        dataid: dataid,
                        name: name,
                        category: category_id,
                        subcategory: subcategory_id,
                        brand: brand_id,
                        unit: unit_id,
                        tp: tp,
                        mrp: mrp,
                        status: status,
                        description: description,
                        profile: profileImage,
                        MultiImages: json_arrs,
                        colorlist: color,
                        sizelist: size
                    },
                    datatype: ("json"),

                    success: function(data) {
                        swal("Data Inserted Successfully", "Form Submited", "success", {
                            timer: 2000
                        });
                        $("#overlay").fadeOut();
                        console.log(data);

                    },
                    error: function(data) {
                        $("#overlay").fadeOut();
                        swal("Opps! Faild", "Form Submited Faild", "error");
                        console.log(data);
                    }

                });


            }
        }

        function clear() {
            editRespomse = 0;

            //ItemDatalist();
            $("#productid").val("");
            $("#name").val("");
            $("#category").val("");
            $("#subcategory").empty();
            $("#brand").empty();
            $("#unit").val("");
            $("#tp").val("0");
            $("#mrp").val("0");
            $("#status").val("1");
            $("#search").val("");
            /*     $("#vattype").val(""); */

        }
        $("#tp").on('click', function() {
            $("#tp").val("");
        })
        $("#mrp").on('click', function() {
            $("#mrp").val("");
        })


        window.onload = itemDetails("{{ $id }}");
        $("#search").on('input', function() {

            var val = this.value;
            if ($('#product option').filter(function() {
                    return this.value.toUpperCase() === val.toUpperCase();
                }).length) {
                var productid = $('#product').find('option[value="' + val + '"]').attr('id');
                itemDetails(productid);
            }
        });

        function itemDetails(id) {
            $.ajax({
                type: 'get',
                url: "{{ route('product.getDataById') }}",
                data: {
                    id: id
                },
                datatype: 'JSON',
                success: function(data) {
                    $('#imgProfile').attr('src', '');
                    dataid = data.id;
                    SubcategoryChange(data.category_id, data.subcategory_id);
                    BrandChange(data.category_id, data.brand_id);
                    $("#productid").val(data.id);
                    $("#barcodes").val(data.barcode);
                    $("#proname").val(data.name);
                    // $("#category option[value='" + data.category_id + "']").attr('selected', 'selected');
                    $("#category").val(data.category_id);
                    // $("#unit option[value='" + data.unit_id + "']").attr('selected', 'selected');
                    $("#unit").val(data.unit_id);
                    // $("#inputdate").val(data.openingDate);
                    $("#tp").val(data.tp);
                    $("#mrp").val(data.mrp);
                    $("#qty").val(data.qty);
                    $("#remark").val(data.remark);
                    //   $("#vattype option[value='" + data.VatSetting_id + "']").attr('selected', 'selected');
                    //    $("#vatvalue").val(data.vat_name['value']);
                    $("#status option[value='" + data.status + "']").attr('selected', 'selected');


                    var filename = 'ProductConfig-' + data.id + '.txt';
                    var file = "{{ asset('storage/app/public/product/description') }}/" + filename;
                    $('#description').load(file, function(data) { // dummy DIV to hold data 
                        var line = data.split('\n')
                    });
                    /*   $.get(file, function(content) {
                          // if you have one tinyMCE box on the page:
                          tinyMCE.get('description').setContent(content);
                      }); */
                    var imagesrc;
                    profileImage = data.image;
                    console.log(profileImage);
                    if (data.image !== null) {
                        imagesrc = "{{ asset('storage/app/public/product/image/profile') }}/" + data.image;
                        convertImgToBase64(imagesrc, function(base64Img) {
                            $('#imgProfile').attr('src', base64Img);
                        });
                    }

                    LoadMultipleImage(data.muli_image);
                },
                error: function(data) {
                    // console.log(data);
                }
            });
        }

        function LoadMultipleImage(data) {
            var file = "{{ asset('storage/app/public/product/image/multiple') }}/";
            var output = $(".preview-images-zone");
            output.empty();
            data.forEach(function(value) {
                MultiImage.push(value['image']);
            });

            //console.log(MultiImage);
            data.forEach(function(value) {

                imagesrc = file + value.image;
                var src;
                var html;
                convertImgToBase64(imagesrc, function(base64Img) {
                    // $('#img-upload').attr('src', base64Img);
                    src = base64Img;
                    html = '<div class="preview-image preview-show-' + num + '">' +
                        '<div class="image-cancel" data-no="' + num + '">x</div>' +
                        '<div class="image-zone"><img class="images" id="pro-img-' + num + '" src="' + src + '" ></div>' +
                        '</div>';
                    output.append(html);
                    num = num + 1;

                });


            });
        }

        function convertImgToBase64(url, callback, outputFormat) {
            var canvas = document.createElement('CANVAS');
            var ctx = canvas.getContext('2d');
            var img = new Image;
            img.crossOrigin = 'Anonymous';
            img.onload = function() {
                canvas.height = img.height;
                canvas.width = img.width;
                ctx.drawImage(img, 0, 0);
                var dataURL = canvas.toDataURL(outputFormat || 'image/png');
                callback.call(this, dataURL);
                // Clean up
                canvas = null;
            };
            img.src = url;
        }

        function SubcategoryChange(categoryid, subcategory_id) {
            if (categoryid) {
                $.ajax({
                    type: "GET",
                    url: "{{url('Admin/Product/get-subcategory-list')}}?category_id=" + categoryid,
                    success: function(res) {
                        if (res) {
                            $("#subcategory").empty();
                            $("#subcategory").append('<option>Select</option>');
                            $.each(res, function(key, value) {
                                $("#subcategory").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            //   $("#subcategory option[value='" + subcategory_id + "']").attr('selected', 'selected');
                            $("#subcategory").val(subcategory_id);
                        } else {
                            $("#subcategory").empty();
                        }
                    }
                });
            } else {
                $("#subcategory").empty();

            }
        }

        function BrandChange(categoryid, brand_id) {
            if (categoryid) {
                $.ajax({
                    type: "GET",
                    url: "{{url('Admin/Product/get-Brand-list')}}?category_id=" + categoryid,
                    success: function(data) {
                        if (data) {
                            $("#brand").empty();
                            $("#brand").append('<option>Select</option>');
                            $.each(data, function(index, value) {
                                $("#brand").append('<option value="' + value.brand_name['id'] + '">' + value.brand_name['title'] + '</option>');
                            });
                            // $("#brand option[value='" + brand_id + "']").attr('selected', 'selected');
                            $("#brand").val(brand_id);
                        } else {
                            $("#brand").empty();
                        }
                    }
                });
            } else {
                $("#brand").empty();
            }
        }

        //reset

        $("#reset").on("click", function(e) {
            clear();
        });

        //data delete

        $("#deletedata").on("click", function(e) {
            if (editRespomse == 1) {
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this  data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var dataid = $("#productid").val();
                            $.ajax({
                                type: "post",
                                url: "{{ url('Admin/Product/delete')}}" + '/' + dataid,
                                success: function(data) {
                                    clear();
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

            }

        });

        $(document).ready(function() {
            document.getElementById('pro-image').addEventListener('change', readImage, false);
            $(".preview-images-zone").sortable();

            $(document).on('click', '.image-cancel', function() {
                let no = $(this).data('no');
                $(".preview-image.preview-show-" + no).remove();
            });
        });


        function readImage() {
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files; //FileList object
                var output = $(".preview-images-zone");
                for (let i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (!file.type.match('image')) continue;
                    var picReader = new FileReader();
                    picReader.addEventListener('load', function(event) {
                        var picFile = event.target;
                        var html = '<div class="preview-image preview-show-' + num + '">' +
                            '<div class="image-cancel" data-no="' + num + '">x</div>' +
                            '<div class="image-zone"><img class="images" id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                            '</div>';
                        output.append(html);
                        num = num + 1;
                    });

                    picReader.readAsDataURL(file);

                }
                $("#pro-image").val('');
            } else {
                console.log('Browser not support');
            }
        }



        function upload() {
            $("#overlay").fadeIn();
            var obj = tinymce.get('description').getContent();
            objArray.push(obj);
            var dataid = $("#productid").val();
            var MultiIms = [];
            var colorlist = new Array();
            var color = {};
            color = $("#mulitcolor").val();

            var sizelist = new Array();
            var size = {};
            size = $("#multisize").val();
            let form_data = new FormData();

            form_data.append("dataid", dataid);
            form_data.append("datainsert", 1);
         /*    form_data.append("barcode", $("#barcodes").val()); */
            form_data.append("name", $("#proname").val());
            form_data.append("category", $("#category").val());
          /*   form_data.append("subcategory", $("#subcategory").val()); */
            form_data.append('brand', $("#brand").val());
            form_data.append("unit", $("#unit").val());
           /*  form_data.append("tp", $("#tp").val()); */
            form_data.append("mrp", $("#mrp").val());
            form_data.append("status", $("#status").val());
            /*  form_data.append("description", tinymce.get("description").getContent()); */
            form_data.append("description", objArray);
            form_data.append("profile", profileImage);


            let totalimages = $("#imag-zon  img").length
            /* if (totalimages > 0) {  */
            //console.log($("#imag-zon  img").length)
            var items = document.querySelectorAll('#imag-zon img');
            items.forEach(function(value, i) {
                value.id = 'pro-img-' + i;
            })
            for (let i = 0; i < totalimages; i++) {
                var imagedata = $("pro-img-" + i).data("imagedata")
                var ImageURL = document.getElementById("pro-img-" + i).src;
                var block = ImageURL.split(";");
                var contentType = block[0].split(":")[1]; // In this case "image/gif"
                var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."
                var blob = b64toBlob(realData, contentType);
                form_data.append('files[]', blob);
            }
            form_data.append('TotalImages', totalimages);
            $.ajax({
                url: "{{route('product.uploadImage')}}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                datatype: ("json"),
                success: function(data) {
                    swal("Data Update Successfully", "Form Submited", "success", {
                        timer: 2000
                    });
                    $("#overlay").fadeOut();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $("#overlay").fadeOut();
                }
            });
            /*    } else {
                   InsertData(json_arr);
               } */

        }

        function b64toBlob(b64Data, contentType, sliceSize) {
            contentType = contentType || '';
            sliceSize = sliceSize || 512;

            var byteCharacters = atob(b64Data);
            var byteArrays = [];

            for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                var slice = byteCharacters.slice(offset, offset + sliceSize);

                var byteNumbers = new Array(slice.length);
                for (var i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                var byteArray = new Uint8Array(byteNumbers);

                byteArrays.push(byteArray);
            }

            var blob = new Blob(byteArrays, {
                type: contentType
            });
            return blob;
        }


        $imgSrc = $('#imgProfile').attr('src');

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imgProfile').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#btnChangePicture').on('click', function() {
            // document.getElementById('profilePicture').click();


            if (!$('#btnChangePicture').hasClass('changing')) {

                $('#profilePicture').click();

            } else {
                $("#profilePicture").html('<span class="spinner-border spinner-border-sm"></span>');
                var name = document.getElementById("profilePicture").files[0].name;
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'jfif']) == -1) {
                    alert("Invalid Image File");
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("profilePicture").files[0]);
                var f = document.getElementById("profilePicture").files[0];
                var fsize = f.size || f.fileSize;
                if (fsize > 10000000) {
                    alert("Image File Size is very big");
                } else {
                    form_data.append("file", document.getElementById('profilePicture').files[0]);
                    $.ajax({
                        type: 'post',
                        url: "{{ route('product.profileUpload')}}",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            profileImage = data;
                            console.log(profileImage);

                            $('#btnChangePicture').addClass('Update');
                            $('#btnChangePicture').removeClass('changing');
                            $("#btnChangePicture").hide();
                            $('#btnDiscard').attr('value', 'Delete Profile');


                        },
                        error: function(data) {
                            console.log(data)
                        }
                    });
                }
            }
        });

        function ProfileUpload() {
            $("#profilePicture").html('<span class="spinner-border spinner-border-sm"></span>');
            var name = document.getElementById("profilePicture").files[0].name;
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'jfif']) == -1) {
                alert("Invalid Image File");
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("profilePicture").files[0]);
            var f = document.getElementById("profilePicture").files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 200000000) {
                alert("Image File Size is very big");
            } else {
                form_data.append("file", document.getElementById('profilePicture').files[0]);
                $.ajax({
                    type: 'post',
                    url: "{{ route('product.profileUpload')}}",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        profileImage = data;
                        console.log(profileImage);

                        $('#btnChangePicture').addClass('Update');
                        $('#btnChangePicture').removeClass('changing');
                        $("#btnChangePicture").hide();
                        $('#btnDiscard').attr('value', 'Delete Profile');


                    },
                    error: function(data) {
                        console.log(data)
                    }
                });
            }
        }

        $('#profilePicture').on('change', function() {
            readURL(this);
            $('#btnChangePicture').addClass('changing');
            $('#btnChangePicture').attr('value', 'Confirm');
            $('#btnDiscard').removeClass('d-none');

            // $('#imgProfile').attr('src', '');
        });
        $('#btnDiscard').on('click', function() {
            // if ($('#btnDiscard').hasClass('d-none')) {
            $("#btnChangePicture").show();
            $('#btnChangePicture').removeClass('changing');
            $('#btnChangePicture').attr('value', 'Change');
            $('#btnDiscard').addClass('d-none');
            $('#imgProfile').attr('src', $imgSrc);
            $('#profilePicture').val('');
            // }
        });
    });
</script>



@endsection
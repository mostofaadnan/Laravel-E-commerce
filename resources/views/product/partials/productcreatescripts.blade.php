 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script type="text/javascript">
   var editRespomse = 0;
   var MultiImage = "";
   var profileImage = "";
   var objArray = [];
   tinymce.init({
     selector: 'textarea',
     toolbar_mode: 'floating',
     height: 250,
     templates: objArray
   });

   function Barcode() {
     $.ajax({
       type: 'get',
       url: "{{ route('product.barcodemaker') }}",
       datatype: 'json',
       success: function(data) {
         $("#barcodes").val(data);
       },
       error: function(data) {}
     });
   }

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
   window.onload = Barcode();
   window.onload = ItemDatalist();

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

   /*  function DataInsert(MultiImagess) {
     var colorlist = new Array();
     var color = {};
     color = $("#mulitcolor").val();

     var sizelist = new Array();
     var size = {};
     size = $("#multisize").val();

     var form_data = new FormData();
     var name = $("#name").val();


     var category_id = $("#category").val();
     var subcategory_id = $("#subcategory").val();
     var brand_id = $("#brand").val();
     var unit_id = $("#unit").val();
     var tp = $("#tp").val();
     var mrp = $("#mrp").val();



     if (name == "" || category_id == "" || unit_id == "" || tp == "" || mrp == "" || profileImage == "") {
       $("#overlay").fadeOut();
       swal("Opps! Faild", "Requirment Field Error", "error");
     } else {
     //  var description = $('#' + 'description').html( tinymce.get('description').getContent() );
      // console.log(description);
 
       form_data.append('_token', "{{ csrf_token() }}");
       form_data.append("barcode", $("#barcodes").val());
       form_data.append("name", $("#name").val());
       form_data.append("category", $("#category").val());
       form_data.append("subcategory", $("#subcategory").val());
       form_data.append('brand', $("#brand").val());
       form_data.append("unit", $("#unit").val());
       form_data.append("tp", $("#tp").val());
       form_data.append("mrp", $("#mrp").val());
       form_data.append("status", $("#status").val());
      //form_data.append("description", );
       form_data.append("profile", profileImage);
       form_data.append("MultiImage", MultiImagess);
       form_data.append("colorlist", color);
       form_data.append("sizelist", size);


       $.ajax({
         type: 'POST',
         url: "{{ route('product.storeData') }} ",
         data: form_data,
         processData: false,
         contentType: false,
         datatype: ("json"),

         success: function(data) {
           $("#overlay").fadeOut();
          
           swal("Data Inserted Successfully", "Form Submited", "success", {
             timer: 2000
           });
           clear();


         },
         error: function(data) {
           $("#overlay").fadeOut();
           swal("Opps! Faild", "Form Submited Faild", "error");
           console.log(data);
         }

       });
     }
   } */

   function clear() {
     editRespomse = 0;
     profileImage = "";
     Barcode();
     $('#imgProfile').attr('src', '');
     $("#productid").val("");
     $("#proname").val("");
     $("#category").val("");
     $("#brand").empty();
     $("#unit").val("");
     $("#mrp").val("0");
     $("#status").val("1");

     //  $("description").val("");
     /*  tinymce.get("description").setContent(""); */
     $("#description").val("");
     var output = $(".preview-images-zone");
     output.empty();
     $('#btnChangePicture').removeClass('changing');
     $('#btnChangePicture').attr('value', 'Change');
     $('#btnChangePicture').removeClass('Update');
     $('#btnDiscard').removeClass('d-none');

     $("#btnChangePicture").hide();
     $("#btnChangePicture").show();
     $("#btnChangePicture").show();


   }

   $("#mrp").on('click', function() {
     $("#mrp").val("");
   })

   $("#search").on('input', function() {

     var val = this.value;
     if ($('#product option').filter(function() {
         return this.value.toUpperCase() === val.toUpperCase();
       }).length) {
       var productid = $('#product').find('option[value="' + val + '"]').attr('id');
       $.ajax({
         type: 'post',
         url: "{{ url('Session-Id/productId')}}" + '/' + productid,
         success: function() {
           itemDetails();
         }
       });
     }
   });

   function SubcategoryChange(categoryid, subcategory_id) {
     if (categoryid) {
       $.ajax({
         type: "GET",
         url: "{{url('Product/get-subcategory-list')}}?category_id=" + categoryid,
         success: function(res) {
           if (res) {
             $("#subcategory").empty();
             $("#subcategory").append('<option>Select</option>');
             $.each(res, function(key, value) {
               $("#subcategory").append('<option value="' + key + '">' + value +
                 '</option>');
             });
             $("#subcategory option[value='" + subcategory_id + "']").attr('selected', 'selected');
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
         url: "{{url('Product/get-Brand-list')}}?category_id=" + categoryid,
         success: function(data) {
           if (data) {
             $("#brand").empty();
             $("#brand").append('<option>Select</option>');
             $.each(data, function(index, value) {
               $("#brand").append('<option value="' + value.brand_name['id'] + '">' + value.brand_name['title'] + '</option>');
             });
             $("#brand option[value='" + brand_id + "']").attr('selected', 'selected');
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
               url: "{{ url('Product/delete')}}" + '/' + dataid,
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
   var num = 1;

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
       if ($('#multiimageupload').hasClass('update')) {
         $('#multiimageupload').text('Update');
         $("#multiimageupload").css("background-color", "Teal");
       }


     } else {
       console.log('Browser not support');
     }
   }


   function DeleteUploadImage() {
     $("#deleteMultiple").html('<span class="spinner-border spinner-border-sm"></span>');
     // console.log(MultiImage.files)
     $.ajax({
       url: "{{route('product.uploadDelete')}}",
       type: 'POST',
       data: {
         MultiImage: MultiImage
       },
       datatype: ("json"),
       success: function(data) {
         console.log(data)
         $("#deleteMultiple").removeClass("spinner-border spinner-border-sm");
         $("#imag-zon").empty();
         $("#multiimageupload").removeClass('update')
         $("#multiimageupload").html('Upload');
         $("#multiimageupload").css("background-color", "#791059");
         $('#deleteMultiple').fadeDelay(3000);
         MultiImage = "";
       },
       error: function(xhr, status, error) {
         console.log(xhr.responseText);

       }
     });
   }
   $.fn.fadeDelay = function(delay) {
     var that = $(this);
     delay = delay || 3000;

     return that.each(function() {

       $(that).queue(function() {

         setTimeout(function() {

           $(that).dequeue();

         }, delay);
       });

       $(that).fadeOut('slow');
     });
   };
   $("#deleteMultiple").on("click", function() {
     DeleteUploadImage();
   });


   /*    function ajaxLoad() {
        var ed = tinyMCE.get("description").getContent();

        // Do you ajax call here, window.setTimeout fakes ajax call
      //  ed.setProgressState(1); // Show progress
        window.setTimeout(function() {
        //  ed.setProgressState(0); // Hide progress
          ed.setContent('HTML content that got passed from server.');
        }, 3000);
      }
    */

   function upload() {
     $("#overlay").fadeIn();
     //  ajaxLoad();
     var obj = tinymce.get('description').getContent();
     objArray.push(obj);
     var name = $("#proname").val();
     var category_id = $("#category").val();
     var subcategory_id = $("#subcategory").val();
     var brand_id = $("#brand").val();
     var unit_id = $("#unit").val();
     var tp = $("#tp").val();
     var mrp = $("#mrp").val();
     var form_data = new FormData();
     if (name == "" || category_id == "" || unit_id == "" || tp == "" || mrp == "" || profileImage == "") {
       $("#overlay").fadeOut();
       swal("Opps! Faild", "Requirment Field Error", "error");
     } else {
       /*  tinyMCE.triggerSave(); */
       //  var ed = tinyMCE.get("description").getContent();

       var colorlist = new Array();
       var color = {};
       color = $("#mulitcolor").val();

       var sizelist = new Array();
       var size = {};
       size = $("#multisize").val();



       //  console.log(profileImage);
       // var token = $('meta[name="csrf-token"]').attr('content');
       // form_data.append("_token", '{{ csrf_token() }}');


       var totalimages = $("#imag-zon  img").length
       //   if (totalimages > 0) {

       //console.log($("#imag-zon  img").length)
       var items = document.querySelectorAll('#imag-zon img');
       items.forEach(function(value, i) {
         console.log(value.id);
         value.id = 'pro-img-' + i;

       })

       form_data.append("datainsert", 0);
       form_data.append("names", $("#proname").val());
       form_data.append("category", $("#category").val());
       form_data.append('brand', $("#brand").val());
       form_data.append("unit", $("#unit").val());
       form_data.append("mrp", $("#mrp").val());
       form_data.append("status", $("#status").val());
       form_data.append("descriptions", objArray);
       form_data.append("profile", profileImage);
       for (var i = 0; i < totalimages; i++) {
         var ImageURL = document.getElementById("pro-img-" + i).src;
         var block = ImageURL.split(";");
         var contentType = block[0].split(":")[1]; // In this case "image/gif"
         var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."
         var blob = b64toBlob(realData, contentType);
         form_data.append('files[]', blob);
       }
       form_data.append('TotalImages', totalimages);
       /*    for (var value of form_data.values()) {
            console.log(value);
          } */
       // var url = "{{ url('Admin/Product/imageupload')}}";

       $.ajax({
         method: 'post',
         url: "{{ url('Admin/Product/imageupload')}}",
         data: form_data,
         dataType: 'json',
         contentType: false,
         cache: false,
         processData: false,

         success: function(data) {

           $("#overlay").fadeOut();
           swal("Data Inserted Successfully", "Form Submited", "success", {
             timer: 2000
           });
           console.log(data);
           clear();


         },
         error: function(xhr, status, error) {
           console.log(xhr.responseText);
           //alert(xhr.responseText);
           $("#overlay").fadeOut();

         }
       });


       /*   }
         else {
           DataInsert(MultiImage);
         } */
     }
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
         $("#overlay").fadeIn();
         form_data.append("_token", "{{ csrf_token() }}");
         form_data.append("file", document.getElementById('profilePicture').files[0]);

         $.ajax({
           type: 'POST',
           url: "{{ route('product.profileUpload')}}",
           data: form_data,
           contentType: false,
           cache: false,
           processData: false,

           success: function(data) {
             $("#overlay").fadeOut();
             swal("Product Profile Upload Successfully", "Form Submited", "success", {
               timer: 2000
             });
             profileImage = data;
             $('#btnChangePicture').addClass('Update');
             $('#btnChangePicture').removeClass('changing');
             $("#btnChangePicture").hide();
             $('#btnDiscard').attr('value', 'Delete Profile');
           },
           error: function(data) {
             $("#overlay").fadeOut();
             console.log(data)
           }
         });
       }
     }
   });
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
 </script>
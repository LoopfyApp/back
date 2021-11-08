@extends('layouts.index')
@section('title') {{__('products.title')}} @endsection

@section('css')
<link rel="stylesheet" href="{{asset('theme/css/vendor/quill.snow.css')}}" />
<link rel="stylesheet" href="{{asset('theme/css/vendor/cropper.min.css')}}" />
@endsection

@section('content')
<main>


    <div class="container-fluid">
        @include('layouts.partials.breadcrumb', ['info' => $datos])

        <div class="row">
            <div class="col-12">
            <form method="POST" enctype="multipart/form-data">
            @csrf

            <input name="id" type="hidden" value="0">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-8 col-sm-12">
                                <label>{{__('products.name')}}</label>
                                <input type="text" maxlength="100" name="name" id="name" class="form-control" required placeholder="{{__('products.name')}}">
                            </div>

                            <div class="form-group col-md-4 col-sm-12">
                                <label>{{__('products.codigo')}}</label>
                                <input type="text" maxlength="10" value="{{@$info->details['codigo']}}" name="codigo" id="codigo" class="form-control" required placeholder="{{__('products.codigo')}}">
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label>{{__('products.category')}}</label>
                                <select class="form-control" name="categories_id" id="categories_id" required>
                                    <option value="">{{__('products.category')}}</option>
                                    @foreach($category as $infocategory)
                                    <option value="{{$infocategory->id}}">{{ $infocategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4 col-sm-12">
                                <label>{{__('products.subcategory')}}</label>
                                <select class="form-control select2-multiple" name="subcategories_id" id="subcategories_id" required>
                                    <option value="">{{__('products.subcategory')}}</option>
                                    @foreach($category as $infocategory)
                                    <option value="{{$infocategory->id}}">{{ $infocategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group  col-md-4 col-sm-12">
                                <label for="status">{{__('products.especies')}} <small style="font-size:10px;color:red">*</small></label>
                                <select class="form-control select2-multiple" multiple="multiple" name="species_id[]" id="species_id" required>
                                </select>
                            </div>

                        </div>

                        <div class="form-row">

                        
                            <div class="form-group col-md-4 col-sm-12">  
                                <label>{{__('products.label_marcas')}} <small style="font-size:10px;color:red">*</small></label>
                                <select class="form-control select2-multiple"   name="brand" id="brand" >
                                <option value="">Seleccione</option> 
                                    @foreach($brand as $infobrand)
                                    <option value="{{$infobrand->id}}">{{ $infobrand->name}}</option>
                                    @endforeach
                                </select>
                            
                            </div>

                            

                             
                            <div class="form-group col-md-2 col-sm-12">
                                <label>{{__('products.label_cantidad')}}  <small style="font-size:10px;color:red">*</small></label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" required >
                            </div>

                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('services.price')}} <b> {{__('services.label_money')}}</b> <small style="font-size:10px;color:red">*</small></label>
                                <input type="text" name="price" id="price" class="form-control" required placeholder="{{__('services.price')}}">
                            </div>

                            <div class="form-group col-md-3 col-sm-12">  
                                <label>{{__('products.label_porte')}} </label>
                                <select class="form-control"   name="porte" id="porte_id" >
                                <option value="">Seleccione</option>
                                <option value="1">Pequeno</option> 
                                <option value="2">M&eacute;dio</option>
                                <option value="3">Grande</option> 
                                <option value="4">Mini</option> 
                                <option value="5">Gigante</option> 
                                </select>
                            
                            </div>

                            
                        </div>



                        <div class="form-row">
                        <div class="form-group  col-md-4  mb-4"><br>
                        <div class="custom-control custom-checkbox mb-4">
                        <input type="checkbox" class="custom-control-input" id="offerts_products" name="offerts_products">
                        <label class="custom-control-label" for="offerts_products">Coloque o produto em oferta</label></div>
                        </div>


                            <div class="form-group col-md-4 col-sm-12">
                                <label>{{__('services.price')}} (em oferta) <b> {{__('services.label_money')}}</b> <small style="font-size:10px;color:red">*</small></label>
                                <input type="text" readonly name="price_offerts" id="price_offerts" class="form-control" required placeholder="{{__('services.price')}}">
                            </div>

                        </div>



                        <div class="form-row">
 
                        <div class="form-group  col-md-12 col-sm-12">
                                <label>{{__('products.description')}}</label>
                                <div id="quill-description"></div>
                                <input type="hidden" name="description" id="description"  >
                            </div>

                        

                        </div>
                        <div class="form-row">
                       
                        <div class="form-group col-md-12 col-sm-12">
                        <h5 class="mb-4">Embalagem</h5>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('products.label_altura')}} </label>
                                <input class="form-control"  name="altura" id="altura" placeholder="{{__('products.label_altura')}}">
                            </div>

                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('products.label_largo')}} </label>
                                <input class="form-control"  name="largo" id="largo" placeholder="{{__('products.label_largo')}}">
                            </div>


                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('products.label_ancho')}} </label>
                                <input class="form-control"  name="ancho" id="ancho" placeholder="{{__('products.label_ancho')}}">
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('products.label_peso')}} </label>
                                <input class="form-control"  name="peso" id="peso" placeholder="{{__('products.label_peso')}}">
                            </div>
                        </div>

                        <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{__('products.label_photo')}}</h5>
                           
                            <label class="btn btn-outline-primary btn-upload" for="inputProducts" title="Upload image file">
                                <input type="file" class="sr-only" id="inputProducts" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                {{__('profile.label_file')}}

                                <input type="hidden" name="photo" id="photo">
                            </label>
                            <div class="row">
                                <div class="col-4">
                                    <div id="cropperContainerProducts">
                                        <img id="cropperProducts" alt="Cropper Image" src="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="cropper_products"></div>
                                </div>
                                <div class="col-2">
                                    <div class="cropper_products"></div>
                                </div>
                                <div class="col-1">
                                    <div class="cropper_products"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{__('products.label_galeria')}}</h5>
                           
                            <label class="btn btn-outline-primary btn-upload" for="imagenes" title="Upload image file">
                                <input type="file" class="sr-only" name="imagenes[]" id="imagenes" multiple accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" >
                                {{__('profile.label_file')}}
 
                            </label> 
                        </div>
                        <div class="row" id="fotos_new">
                        </div><br><br>
                    </div>
                        
                        

                        <button class="btn btn-success" type="submit">Registrar</button>
                        </div>
                        
                        </div>


                       
            </form>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')

<script src="{{asset('theme/js/vendor/cropper.min.js')}}"></script>

<script src="{{asset('theme/js/vendor/quill.min.js')}}"></script>
<script src="{{asset('theme/js/vendor/number_money.js')}}"></script>
<script>
            /**
             *  Simple JavaScript Promise that reads a file as text.
             **/
            function readFileAsText(file){
                return new Promise(function(resolve,reject){
                    let fr = new FileReader();

                    fr.onload = function(){
                        resolve(fr.result);
                    };

                    fr.onerror = function(){
                        reject(fr);
                    };

                    fr.readAsDataURL(file);
                });
            }

            // Handle multiple fileuploads
            document.getElementById("imagenes").addEventListener("change", function(ev){
                let files = ev.currentTarget.files;
                let readers = [];

                // Abort if there were no files selected
                if(!files.length) return;

                // Store promises in array
                for(let i = 0;i < files.length;i++){
                    readers.push(readFileAsText(files[i]));
                }
                
                // Trigger Promises
                Promise.all(readers).then((values) => {
                    var output = $('#fotos_new');
                    output.html("");
                    for(var x=0;x<values.length;x++){
                    output.append('<div class="col-md-3"><img style="width:100%" src="'+values[x]+'" alt="imagen"></div>')
                }
                    console.log(values.length);
                });
            }, false);
        </script>
 

<script>
    var Cropper = window.Cropper;
    if (typeof Cropper !== "undefined") {
      function each(arr, callback) {
        var length = arr.length;
        var i;

        for (i = 0; i < length; i++) {
          callback.call(arr, arr[i], i, arr);
        }

        return arr;
      }
      $("#cropperProducts").css('display','none')
      var previews = document.querySelectorAll(".cropper_products");
      var options = {
        aspectRatio: 1/1,
        preview: ".img-preview",
        ready: function() {
          var clone = this.cloneNode();

          clone.className = "";
          clone.style.cssText =
            "display: block;" +
            "width: 100%;" +
            "min-width: 0;" +
            "min-height: 0;" +
            "max-width: none;" +
            "max-height: none;";
          each(previews, function(elem) {
            elem.appendChild(clone.cloneNode());
          });
        },
        crop: function(e) {
          var data = e.detail;
          var cropper = this.cropper;
          var imageData = cropper.getImageData();
          var previewAspectRatio = data.width / data.height;
          var canvas = cropper.getCroppedCanvas();
          $("#photo").val(canvas.toDataURL())
          each(previews, function(elem) {
            var previewImage = elem.getElementsByTagName("img").item(0);
            var previewWidth = elem.offsetWidth;
            var previewHeight = previewWidth / previewAspectRatio;
            var imageScaledRatio = data.width / previewWidth;
            elem.style.height = previewHeight + "px";
            if (previewImage) {
              previewImage.style.width =
                imageData.naturalWidth / imageScaledRatio + "px";
              previewImage.style.height =
                imageData.naturalHeight / imageScaledRatio + "px";
              previewImage.style.marginLeft = -data.x / imageScaledRatio + "px";
              previewImage.style.marginTop = -data.y / imageScaledRatio + "px";
            }
          });
        },
        zoom: function(e) {}
      };

      if ($("#inputProducts").length > 0) {
        var inputProducts = $("#inputProducts")[0];
        var image = $("#cropperProducts")[0];

        var cropper;
        inputProducts.onchange = function() {
          var files = this.files;
          var file;

          if (files && files.length) {
            file = files[0];
            $("#cropperContainerProducts").css("display", "block");

            if (/^image\/\w+/.test(file.type)) {
              uploadedImageType = file.type;
              uploadedImageName = file.name;

              image.src = uploadedImageURL = URL.createObjectURL(file);
              if (cropper) {
                cropper.destroy();
              }
              cropper = new Cropper(image, options);
              inputProducts.value = null;
            } else {
              window.alert("Please choose an image file.");
            }
          }
        };
      }
    }
</script>

<script>

var quillToolbarOptionsContents = [
        ["bold", "italic", "underline", "strike"],
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }],
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }],
        [{ indent: "-1" }, { indent: "+1" }],
        [{ direction: "rtl" }],

        [{ size: ["small", false, "large", "huge"] }],
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }],
        [{ font: [] }],
        [{ align: [] }],

        ["clean"]
      ];

      var quill_description = new Quill('#quill-description', {
                modules: { toolbar: quillToolbarOptionsContents },
                theme: 'snow'
            });

            $('#quill-description').css('height','200px').html();
            quill_description.on('text-change', function(delta, oldDelta, source) {
                document.getElementById("description").value = quill_description.root.innerHTML;
            });
            
 

      
    $('#service_days').select2()
    $('#price').priceFormat({
        prefix: '',
        centsSeparator: '.',
    });
    $("#price_offerts").priceFormat({
        prefix: '',
        centsSeparator: '.',
    });
    jQuery.ajaxSetup({
        async: true
    });

    $('#offerts_products').change(function(){
       if($(this).is(':checked')){
        $("#price_offerts").removeAttr('readonly');
        $("#price_offerts").val('')
       }
       else{
        $("#price_offerts").attr('readonly', true);
        $("#price_offerts").val('0.00')
       }
    })
    $("#categories_id").change(function() {
        var valor = $("#categories_id").val();
        selectoptions(valor, 0);
    });

    $("#subcategories_id").change(function() {
        var valor = $("#subcategories_id").val();
        if(valor > 0){
        selectoptionsAnimals(valor, 0);}
    });

   
    var valor = $("#categories_id").val();
    selectoptions(valor, 0);

    function selectoptions(valor, ids) {
        $.ajax({
            type: 'GET',
            url: "{{url('business/products/subcategorys/')}}/" + valor,

            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data)
                $('#subcategories_id').empty();
                $.each(data, function(i, item) {
                    $('#subcategories_id').append('<option value=' + item.id + '>' + item.name + '</option>');

                });
                if (ids == 0) {

                    $('#subcategories_id').change();
                } else {
                    $("#subcategories_id").val(ids).change();
                }

            }
        });
    }

    function selectoptionsAnimals(valor, ids) {
        $.ajax({
            type: 'GET',
            url: "{{url('business/products/species/')}}/" + valor,

            contentType: false,
            processData: false,
            success: function(data) {
                $('#species_id').empty();
                $.each(data, function(i, item) {
                    $('#species_id').append('<option value=' + item.id + '>' + item.name + '</option>');

                });
                if (ids == 0) {

                    $('#species_id').change();
                } else {
                    $("#species_id").val(ids).change();
                }

            }
        });
    }
</script>

@endsection
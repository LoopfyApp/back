@extends('layouts.index')
@section('title') {{__('profile.title')}} @endsection

@section('css')
<link rel="stylesheet" href="{{asset('theme/css/vendor/cropper.min.css')}}" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css"
/>
<style>
  .leaflet-geosearch-bar {
    position: relative;
    display: block;
    height: auto;
    width: 400px;
    max-width: calc(100% - 120px);
    margin: 10px auto 0;
    cursor: auto;
    z-index: 1000;
}
  #map {
	border-radius:.125em;
	border:2px solid #1978cf;
	margin: 4px 0;
	float:left;
	width:100%;
	height:400px;	
}
#cropperContainer2 {
    height: 300px;
    display: none;
}

#cropperContainer2 .cropper-view-box,
    #cropperContainer2 .cropper-face {
      border-radius: 50%;
    }

</style>
@endsection

@section('content')
<main>


    <div class="container-fluid">
        @include('layouts.partials.breadcrumb', ['info' => $datos])

        <div class="row">
            <div class="col-12">

                <div class="card mb-4">

                    <div class="card-body">

                        <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="first" aria-selected="true">{{__('profile.profile')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="first" aria-selected="true">{{__('profile.address')}}</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" id="hours-tab" data-toggle="tab" href="#hours" role="tab" aria-controls="second" aria-selected="false">{{__('profile.hours')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('business.profile.partials.datos')
                            </div>
                            <div class="tab-pane" id="address" role="tabpanel" aria-labelledby="address-tab">
                            @include('business.profile.partials.enderezo')
                            </div>
                            <div class="tab-pane" id="hours" role="tabpanel" aria-labelledby="hours-tab">
                            @include('business.profile.partials.horario')
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')

<script src="{{asset('theme/js/vendor/cropper.min.js')}}"></script>


<script>

function getRoundedCanvas(sourceCanvas) {
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      var width = sourceCanvas.width;
      var height = sourceCanvas.height;

      canvas.width = width;
      canvas.height = height;
      context.imageSmoothingEnabled = true;
      context.drawImage(sourceCanvas, 0, 0, width, height);
      context.globalCompositeOperation = 'destination-in';
      context.beginPath();
      context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
      context.fill();
      return canvas;
    }

    function each(arr, callback) {
      var length = arr.length;
      var i;

      for (i = 0; i < length; i++) {
        callback.call(arr, arr[i], i, arr);
      }

      return arr;
    }

 

    var previews = document.querySelectorAll(".cropper-preview2");
      var options = {
        aspectRatio: 1,
    
        preview: ".img-preview",
        ready: function() {
          var clone = this.cloneNode();
          croppable = true;
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
          var croppedCanvas;
          var cropper = this.cropper;
          var imageData = cropper.getImageData();
          var previewAspectRatio = data.width / data.height;
 
          croppedCanvas = cropper.getCroppedCanvas();
          roundedCanvas = getRoundedCanvas(croppedCanvas); 
          roundedImage = document.createElement('img');
          var imagefinal=roundedCanvas.toDataURL() 
          $("#logo").val(imagefinal)
          blob = dataURItoBlob(imagefinal)
          var utils= URL.createObjectURL(blob);

 

          each(previews, function(elem) {
       
            var previewImage =  elem.getElementsByTagName("img").item(0);
            previewImage.src=utils
            var previewWidth = elem.offsetWidth;
            var previewHeight = previewWidth / previewAspectRatio;
            var imageScaledRatio = data.width / previewWidth;
            elem.style.height = previewHeight + "px";
         
              previewImage.style.borderRadius = "100%";
            
          });
        },
        zoom: function(e) {}
      };
 

    if ($("#inputImage2").length > 0) {
        var inputImage = $("#inputImage2")[0];
        var image = $("#cropperImage2")[0];

        var cropper;
        inputImage.onchange = function() {
          var files = this.files;
          var file;

          if (files && files.length) {
            file = files[0];
            $("#cropperContainer2").css("display", "block");

            if (/^image\/\w+/.test(file.type)) {
              uploadedImageType = file.type;
              uploadedImageName = file.name;

              image.src = uploadedImageURL = URL.createObjectURL(file);
              if (cropper) {
                cropper.destroy();
              }
              cropper = new Cropper(image, options);
              inputImage.value = null;
            } else {
              window.alert("Please choose an image file.");
            }
          }
        };
      }

      function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}

    $("#phone").keyup(function (){
    this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    $("#phone_comercial").keyup(function (){
    this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    $('#addressOption').val('{{Auth()->user()->userDetails->address}}')
    $("#cep").blur(function (){
    
 
        $.get("{{route('business.profile.consulta')}}?cep="+$(this).val(), function(data, status){
          if(data.error==true){
            alert('error', "{{__('trademarks.notification.message')}}", data.message);
            $("#cep").val('');
            $('#addressOption').val('')
          }
          else{
 
            $('#addressOption').val(data.data.combinado)
          }
        }).fail(function() {
           console.log('fallo')
          alert('error', "{{__('trademarks.notification.message')}}", data.message);
            $("#cep").val('');
            $('#addressOption').val('')
          })
 
     

      
    });

  </script>

<script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
<script>

const map = L.map('map').setView([51.505, -0.09], 13);
L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
const search = new GeoSearch.GeoSearchControl({
  provider: new GeoSearch.OpenStreetMapProvider(),
});
map.addControl(search);
 
</script>
@endsection
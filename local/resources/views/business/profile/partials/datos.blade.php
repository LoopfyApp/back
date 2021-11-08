<form action="{{route('business.profile.save')}}" method="post"> 
    @csrf
<div class="row">

    <div class="col-12">
 
    <input type="hidden" value="{{Auth()->user()->id}}" name="id_users"> 
    <input type="hidden" value="1" name="opciones">
        <div class="card mb-4">
            <div class="card-body">

            <div class="form-group">
                            <label>CNPJ</label>
                            <input type="text"  readonly class="form-control" value="{{Auth()->user()->userDetails->cnpj}}" >
                        </div>

         
                    <div class="form-group">
                        <label>{{__('profile.label_nome')}}</label>
                        <input type="text" name="razon" required value="{{Auth()->user()->userDetails->razon}}" class="form-control" placeholder="{{__('profile.label_nome')}}">

                    </div>
                    <div class="form-group">
                        <label>{{__('profile.label_commerce')}}</label>
                        <textarea class="form-control" name="description" required   placeholder="{{__('profile.label_commerce')}}">{{Auth()->user()->userDetails->description}}</textarea>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>{{__('profile.label_phone')}}</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{Auth()->user()->userDetails->phone}}"  placeholder="{{__('profile.label_phone')}}">
                        </div>

                        <div class="form-group  col-6">
                            <label>{{__('profile.label_phone_tow')}}</label>
                            <input type="text" class="form-control" id="phone_comercial" name="phone_comercial" value="{{Auth()->user()->userDetails->phone_comercial}}" placeholder="{{__('profile.label_phone_tow')}}">
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{__('profile.label_photo')}}</h5>
                            @if(Auth()->user()->userDetails->photo != null)
                            <img src="{{Auth()->user()->userDetails->photo}}" alt="{{__('profile.label_photo')}}" width="200px">
                            @endif
                            <label class="btn btn-outline-primary btn-upload" for="inputImage" title="Upload image file">
                                <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                {{__('profile.label_file')}}

                                <input type="hidden" name="photo" id="photo">
                            </label>
                            <div class="row">
                                <div class="col-4">
                                    <div id="cropperContainer">
                                        <img id="cropperImage" alt="Cropper Image" src="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="cropper-preview"></div>
                                </div>
                                <div class="col-2">
                                    <div class="cropper-preview"></div>
                                </div>
                                <div class="col-1">
                                    <div class="cropper-preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{__('profile.label_logo')}}</h5>
                            
                            @if(Auth()->user()->userDetails->logo != null)
                            <img src="{{Auth()->user()->userDetails->logo}}" alt="{{__('profile.label_logo')}}" width="200px">
                            @endif
                            <label class="btn btn-outline-primary btn-upload" for="inputImage2" title="Upload image file">
                                <input type="file" class="sr-only" id="inputImage2" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                {{__('profile.label_file')}}
                            </label>
                            <input type="hidden" name="logo" id="logo">
                            <div class="row">
                                <div class="col-4">
                                    <div id="cropperContainer2">
                                        <img id="cropperImage2" alt="Cropper Image" src="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="cropper-preview2" style="width:100%"></div>
                                </div>
                                <div class="col-2">
                                    <div class="cropper-preview2"  style="width:100%"></div>
                                </div>
                                <div class="col-1">
                                    <div class="cropper-preview2"  style="width:100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary mb-0">   {{__('profile.label_update')}}</button>
         

            </div>
        </div>
 
    </div>
</div>
</form>
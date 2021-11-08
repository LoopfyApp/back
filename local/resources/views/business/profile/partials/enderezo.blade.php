<form action="{{route('business.profile.save')}}" method="post"> 
    @csrf
<div class="row">

    <div class="col-12">
 
    <input type="hidden" value="{{Auth()->user()->id}}" name="id_users"> 
    <input type="hidden" value="2" name="opciones">

    <div class="card mb-4">
            <div class="card-body">

            <div class="form-group">
                            <label>CEP</label>
                            <input type="text" maxlength="9" name="cep" id="cep" required class="form-control" value="{{Auth()->user()->userDetails->cep}}" >
            </div>

            <div class="form-group">
                            <label>{{__('profile.label_address')}}</label>
                            <input type="text" name="address" id="addressOption" readonly  required  class="form-control" >
            </div>

            
            <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" name="complemento"    class="form-control" value="{{Auth()->user()->userDetails->complemento}}"   >
            </div>

            <div  class="form-group">

            <div id="map"></div>

            </div>
            </div>
    </div>
    <button type="submit" class="btn btn-primary mb-0">   {{__('profile.label_update')}}</button>


    </div>
</div>
</form>
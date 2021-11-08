 
                            <div class="modal fade modal-right" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{__('subcategory.label_novo')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form id="formCategory" action="{{route('subcategory.store')}}"  class="needs-validation mb-5 was-validated" novalidate method="POST"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">

                                             
                                                <div class="form-group">
                                                    <label for="name">{{__('subcategory.label_name')}} <small style="font-size:10px;color:red">*</small></label>
                                                    <input id="name" name="name"type="text" class="form-control" placeholder="" required>
                                                </div>

                                           

                                                <div class="form-group">
                                                    <label for="logo">{{__('subcategory.label_logo')}} <small style="font-size:10px;color:red">* Formato solo svg.</small></label>
                                                    <input name="logo" accept=".svg" id="logo" type="file" class="form-control" placeholder="" >
                                   
                                                </div>
                                                
                                                <div class="form-group" id="add_edits">

                                                </div>

                                                <div class="form-group">
                                                    <label for="status">{{__('subcategory.label_category')}}  <small style="font-size:10px;color:red">*</small></label>
                                                    <select class="form-control" name="categories_id" id="categories_id" required>
                                                        <option value="">{{__('subcategory.label_category')}}</option>
                                                        @foreach($category as $infocategory)
                                                        <option value="{{$infocategory->id}}">{{ $infocategory->name}}</option>  
                                                        @endforeach 
                                                    </select>
                                                </div>
                                                 


                                                <div class="form-group">
                                                    <label for="status">{{__('category.label_species')}}  <small style="font-size:10px;color:red">*</small></label>
                                                    <select class="form-control select2-multiple" multiple="multiple" name="species_id[]" id="species_id"   required>
                                                        
                                                      
                                                    </select>
                                                </div>
                                                

                                                <div class="form-group">
                                                    <label for="status">{{__('subcategory.label_status')}}  <small style="font-size:10px;color:red">*</small></label>
                                                    <select class="form-control" name="status" id="status" required>
                                                   
                                                        <option value="0">{{__('species.active')}}</option>
                                                        <option value="1">{{__('species.inactive')}}</option> 
                                                    </select>
                                                </div>
 
                                       
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">{{__('menu.cancelar')}}</button>
                                            <button type="submit" class="btn btn-primary">{{__('menu.save')}}</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

 
 
                            <div class="modal fade modal-right" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{__('trademarks.label_novo')}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form id="formCategory" action="{{route('trademarks.store')}}"  class="needs-validation mb-5 was-validated" novalidate method="POST"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">

                                             
                                                <div class="form-group">
                                                    <label for="name">{{__('trademarks.label_name')}} <small style="font-size:10px;color:red">*</small></label>
                                                    <input id="name" name="name"type="text" class="form-control" placeholder="" required>
                                            
                                                </div>
                                                <div class="form-group">
                                                    <label for="logo">{{__('trademarks.label_logo')}} <small style="font-size:10px;color:red">* Formato solo svg.</small></label>
                                                    <input name="logo" accept=".svg" id="logo" type="file" class="form-control" placeholder="" >
                                   
                                                </div>
                                                
                                                <div class="form-group" id="add_edits">

                                                </div>

                                                <div class="form-group">
                                                    <label for="status">{{__('trademarks.label_status')}}  <small style="font-size:10px;color:red">*</small></label>
                                                    <select class="form-control" name="status" id="status">
                                                   
                                                        <option value="0">{{__('trademarks.active')}}</option>
                                                        <option value="1">{{__('trademarks.inactive')}}</option> 
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

 
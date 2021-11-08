@extends('layouts.index')
@section('title') {{__('services.title')}} @endsection

@section('css')

@endsection

@section('content')
<main>


    <div class="container-fluid">
        @include('layouts.partials.breadcrumb', ['info' => $datos])

        <div class="row">
            <div class="col-12">
            <form method="POST">
            @csrf
            <input name="id" type="hidden" value="0">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label>{{__('services.name')}}</label>
                                <input type="text" maxlength="100" name="name" id="name" class="form-control" required placeholder="{{__('services.name')}}">
                            </div>

                            <div class="form-group  col-md-8 col-sm-12">
                                <label>{{__('services.description')}}</label>
                                <input type="text" name="description" maxlength="255" id="description" required class="form-control" placeholder="{{__('services.description')}}">
                            </div>

                        </div>



                        <div class="form-row">
                            <div class="form-group col-md-8 col-sm-12">
                                <label>{{__('services.category')}}</label>
                                <select class="form-control" name="categories_id" id="categories_id" required>
                                    <option value="">{{__('subcategory.label_category')}}</option>
                                    @foreach($category as $infocategory)
                                    <option value="{{$infocategory->id}}">{{ $infocategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group  col-md-4 col-sm-12">
                                <label for="status">{{__('category.label_species')}} <small style="font-size:10px;color:red">*</small></label>
                                <select class="form-control select2-multiple" multiple="multiple" name="species_id[]" id="species_id" required>
                                </select>
                            </div>

                        </div>




                        <div class="form-row">
                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('services.price')}} <b> {{__('services.label_money')}}</b></label>
                                <input type="text" name="price" id="price" class="form-control" required placeholder="{{__('services.price')}}">
                            </div>

                        

                            <div class="form-group  col-md-3 col-sm-12">
                                <label>{{__('services.time_hours')}}</label>
                                <select class="form-control" name="time_hours" id="time_hours" required>
                                    <option value="">{{__('services.time_hours')}}</option>
                                    <option value="15">15 min</option>
                                    <option value="30">30 min</option>
                                    <option value="45">45 min</option>
                                    <option value="60">60 min</option>
                                </select>
                            </div>

                            <div class="form-group  col-md-6 col-sm-12">
                                <label>{{__('services.service_days')}}</label>
                                <select class="form-control select2-multiple" name="service_days[]" id="service_days" required multiple>

                                    @for($a=1;$a<=7;$a++) <option value="{{$a}}">{{__('profile.label_day_'.$a)}}</option>
                                        @endfor
                                </select>
                            </div>


 
                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('services.hour_open')}} </label>
                                <input type="time" name="hour_inicio" id="hour_inicio" class="form-control" required placeholder="{{__('services.hour_open')}}">
                            </div>

                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('services.hour_close')}}</label>
                                <input type="time" name="hour_fin" id="hour_fin" class="form-control" required placeholder="{{__('services.hour_close')}}">
                            </div>
 
                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('services.hour_open_break')}} </label>
                                <input type="time" name="hour_open_break" id="hour_open_break" class="form-control" required placeholder="{{__('services.hour_open_break')}}">
                            </div>

                            <div class="form-group col-md-3 col-sm-12">
                                <label>{{__('services.hour_close_break')}}</label>
                                <input type="time" name="hour_close_break" id="hour_close_break" class="form-control" required placeholder="{{__('services.hour_close_break')}}">
                            </div>


                        </div>

                        <button class="btn btn-success" type="submit">Registrar</button>
                    </div>
                    
            </form>
                    
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@section('js')

<script src="{{asset('theme/js/vendor/number_money.js')}}"></script>

<script>
    $('#service_days').select2()
    $('#price').priceFormat({
        prefix: '',
        centsSeparator: '.',

    });
    jQuery.ajaxSetup({
        async: true
    });
    $("#categories_id").change(function() {
        var valor = $("#categories_id").val();
        selectoptions(valor, 0);
    });

    var valor = $("#categories_id").val();
    selectoptions(valor, 0);

    function selectoptions(valor, ids) {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/category/details/')}}/" + valor,

            contentType: false,
            processData: false,
            success: function(data) {
                $('#species_id').empty();
                $.each(data.especies, function(i, item) {
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
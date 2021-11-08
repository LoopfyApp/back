@extends('layouts.index')
@section('title') {{__('products.title')}} @endsection

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css" />

@endsection

@section('content')
<main>


    <div class="container-fluid">

        @include('layouts.partials.breadcrumb', ['info' => $datos])



        <div class="row">
            <div class="col-12">

                <div class="card mb-4">

                    <div class="card-body">

                        <a type="button" href="{{route('business.products.add')}}" style="width:35%" class="float-sm-right btn btn-primary btn-sm top-right-button "><i class="simple-icon-plus"></i>{{__('products.add')}}</a>

                        <div class="jumbotron">
                            <h3>{{$datos['subtitles']}}</h3>

                            <hr class="my-4">

                            <table id="table_services" class="table display responsive nowrap" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>{{__('products.name')}}</th>
                                        <th>{{__('products.category')}}</th> 
                                        <th>{{__('products.label_status')}}</th>
                                        <th>{{__('products.price')}}</th>
                                        <th data-priority="1">{{__('products.label_options')}}</th>
                                    </tr>
                                </thead>
                            </table>


                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@section('js')


<script>
    jQuery.ajaxSetup({
        async: true
    });


    var table = $('#table_services').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{route("business.products.index")}}',
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'categorys',
                name: 'categorys'
                
            },

            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    });

    function activar(idvalor) {

        $.ajax({
            type: 'GET',
            url: "{{url('business/products/status/')}}/" + idvalor,

            contentType: false,
            processData: false,
            success: function(data) {
                alert('success', "{{__('services.notification.message')}}", data.mensaje);

                table.ajax.reload();
            }
        });
    }

    
  $('#table_services').on('click', '#editar_species', function () { 
                 var Info=$(this).attr('data-current');
                 confirmation("{{__('general.information')}}", "{{__('general.edit')}}", 'warning', "{{__('general.edit')}}").then(datos=>{
                     if(datos.isConfirmed){
                         window.location.href="{{url('business/products/edit')}}/"+Info

                     }
                 });
                 
            });

</script>

@endsection
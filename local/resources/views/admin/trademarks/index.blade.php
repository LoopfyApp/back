@extends('layouts.index')
@section('title') {{__('species.title')}} @endsection

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
                       
                                <button type="button" style="font-size:20px;width:20%" id="addModal" class="float-sm-right btn btn-primary btn-sm top-right-button "><i class="simple-icon-plus"></i></button>
                       
                            <div class="jumbotron">
                                <h3>{{$datos['subtitles']}}
                            
                                </h3>     
                              
                                <hr class="my-4">
                               @include('admin.trademarks.partials.table')
                               @include('admin.trademarks.partials.modal_form')
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
jQuery.ajaxSetup({async:true});
 
 
  var table=  $('#table_species').DataTable( {
         processing: true,
        serverSide: true,
        ajax: '{{route("trademarks.index")}}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},  
            {data: 'logo', name: 'logo'},
            {data: 'name', name: 'name'},
            {data:'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    } );
 
    new $.fn.dataTable.FixedHeader( table );

    
    $("#addModal").click(function(event) {
        $('#formCategory')[0].reset();
        $('#exampleModalRight').modal('toggle')   
        $("#add_edits").html("");
        
    });

    $("#formCategory").submit(function(event) {
        if($('#formCategory')[0].checkValidity()) {
        var datosfm=new FormData($('#formCategory')[0]);
        $("#Iguardar").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
        $("#Guardar").attr('disabled')
        $.ajax({
                type:'POST',
                url:"{{route('trademarks.store')}}",
                data:datosfm,
                contentType: false,
                processData: false,
                success:function(data){
                    table.ajax.reload();
                    if(data.status==false){
                        alert('success', "{{__('trademarks.notification.message')}}", "{{__('trademarks.notification.save')}}");
                    }
                    else{
                        alert('error', "{{__('trademarks.notification.message')}}","{{__('trademarks.notification.error')}}")
                    }
                   
                    $('#formCategory')[0].reset();
                    $('#exampleModalRight').modal('toggle')
                }
                });
                event.preventDefault();

            }
    else{
        alert('error', "{{__('trademarks.notification.message')}}","{{__('trademarks.notification.error')}}")    
    }

  } )

 
  $('#table_species').on('click', '#editar_species', function () { 
                 var Info=$(this).attr('data-current');
                 confirmation("{{__('general.information')}}", "{{__('general.edit')}}", 'warning', "{{__('general.edit')}}").then(datos=>{
                     if(datos.isConfirmed){
                         
                        $.ajax({
                            type:'GET',
                            url:"{{url('admin/trademarks/info/')}}/"+Info,

                            contentType: false,
                            processData: false,
                            success:function(data){
                                var template="<input name='id' type='hidden' value='"+data.data.id+"'>";
                                template+="<img src='"+data.data.logo+"' width='25%'>";
                                $("#name").val(data.data.name)
                                $("#logo").removeAttr('required')
                                $("#status").val(data.data.status)
                                $("#add_edits").html(template);
                                $('#exampleModalRight').modal('toggle')
              
                            }
                            });

                     }
                 });
                 
            });

 

function activar(idvalor){

    $.ajax({
                            type:'GET',
                            url:"{{url('admin/trademarks/status/')}}/"+idvalor,

                            contentType: false,
                            processData: false,
                            success:function(data){
                                alert('success', "{{__('trademarks.notification.message')}}", data.mensaje);
                                
                                table.ajax.reload();
                            }
                            });
}

</script>

@endsection
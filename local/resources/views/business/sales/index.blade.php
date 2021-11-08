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

                        <div class="jumbotron">
                            <h3>{{$datos['subtitles']}}</h3>

                            <hr class="my-4">

                            <table id="table_services" class="table display responsive nowrap" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th># Pedido</th>
                                        <th>Dados do usuário</th>
                                        <th>Total da compra</th> 
                                        <th>{{__('products.label_status')}}</th>
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
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    }); 

</script>

@endsection
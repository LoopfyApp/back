@extends('layouts.index')
@section('title') {{__('products.title')}} @endsection

@section('css')

 
@endsection

@section('content')
<main>


    <div class="container-fluid">

        

        <div class="row">
            <div class="col-12">

                <div class="card mb-4">

                    <div class="card-body">
                    <div id='calendar'></div>
                       
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

    $('#calendar').fullCalendar({
    themeSystem: 'bootstrap4',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month'
    },
    weekNumbers: true,
    eventLimit: true, // allow "more" link when too many events
    events: []
  });

</script>

@endsection
<form action="{{route('business.profile.save')}}" method="post">
    @csrf
    <div class="row">

        <div class="col-12">

            <input type="hidden" value="{{Auth()->user()->id}}" name="id_users">
            <input type="hidden" value="3" name="opciones">

            <div class="card mb-4">
                <div class="card-body">
@php
$horario=Auth()->user()->userhours()->get();
$x=0;
@endphp

                @for($a=1;$a<=7;$a++)
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>{{__('profile.label_day_'.$a)}}</label>

                        </div>


                        <div class="form-group col-md-4">
                            <label>{{__('profile.label_open')}}</label>
                            <input type="time" name="open_{{$a}}" value="{{@$horario[$x]->open}}"  class="form-control"  >
                        </div>


                        <div class="form-group col-md-4">
                            <label>{{__('profile.label_close')}}</label>
                            <input type="time"  name="close_{{$a}}" class="form-control" value="{{@$horario[$x]->close}}"  >
                        </div>
                    </div>
                    @php 
                    $x++;
                    @endphp
                @endfor

                <button type="submit" class="btn btn-primary mb-0">   {{__('profile.label_update')}}</button>
                </div>

        

            </div>

        </div>
    </div>
</form>
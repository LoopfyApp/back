@extends('layouts.login')
@section('title') Login @endsection

@section('css')

@endsection

@section('content')

<div class="fixed-background"></div>

<div class="container">
    <div class="row h-100">
        <div class="col-12 col-md-10 mx-auto my-auto">
            <div class="card auth-card">
                <div class="position-relative image-side ">

                
                </div>
                <div class="form-side">
                    <a href="{{url('/')}}">
                        <span class="logo-single"></span>
                    </a>
                    <h6 class="mb-4">Login</h6>
                 
                    <form method="POST" action="{{url('login')}}">
                    @csrf
                        <label class="form-group has-float-label mb-4 col-12">
                            <input class="form-control" type="email" name="email" />
                            <span>E-mail</span>
                        </label>

                        <label class="form-group has-float-label mb-4 col-12">
                            <input class="form-control" type="password" name="password" placeholder="" />
                            <span>Password</span>
                        </label>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#">Forget password?</a>
                            <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script>


function showNotification2(placementFrom, placementAlign, type, title, mensaje) {
      $.notify(
        {
          icon: 'simple-icon-exclamation',
          title: title,
          message: mensaje,
          target: "_blank"
        },
        {
          element: "body",
          position: null,
          type: type,
          allow_dismiss: true,
          newest_on_top: false,
          showProgressbar: false,
          placement: {
            from: placementFrom,
            align: placementAlign
          },
          offset: 20,
          spacing: 10,
          z_index: 1031,
          delay: 4000,
          timer: 2000,
          url_target: "_blank",
          mouse_over: null,
          animate: {
            enter: "animated fadeInDown",
            exit: "animated fadeOutUp"
          },
          onShow: null,
          onShown: null,
          onClose: null,
          onClosed: null,
          icon_type: "class",
          template:
            '<div data-notify="container" class="col-11 col-sm-3 alert  alert-{0} " role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>' +
            
            '<span data-notify="title"><span data-notify="icon"></span> {1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            "</div>" +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            "</div>"
        }
      );
    }

    @if ($errors->any())
   
        @foreach ($errors->all() as $error)
            showNotification2("top", "right", 'danger', 'Error', '{{ $error }}');
         
        @endforeach
 
@endif
    </script>

@endsection
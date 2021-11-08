    <script src="{{asset('theme/js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/chartjs-plugin-datalabels.js')}}"></script>
    <script src="{{asset('theme/js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/fullcalendar.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/owl.carousel.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/progressbar.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('theme/js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('theme/js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('theme/js/vendor/Sortable.js')}}"></script>
    <script src="{{asset('theme/js/vendor/mousetrap.min.js')}}"></script>
    <script src="{{asset('theme/js/dore.script.js')}}"></script>
    <script src="{{asset('theme/js/scripts.js')}}"></script>
    <script src="{{asset('theme/js/vendor/sweetalert2.min.js')}}"></script>
 

    
    <script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>

 

<script>
async  function confirmation(title, subtitle, icono, textbutton){
  return  await Swal.fire({
                title: title,
                text: subtitle,
                icon: icono,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: textbutton
                });
}

function alert(icon, title, text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text 
        })
}
function showMsgsuccess(mensaje){
    Swal.fire({
        type: 'success',
        title: 'Mensaje',
        text: mensaje,
        showConfirmButton: true,
        timer: 3500
        })
    
}
function showMsgError(mensaje){
    Swal.fire({
  type: 'error',
  title: 'Oops...',
  text: mensaje,
  showConfirmButton: true,
  timer: 3500
})
}

@if(Session::has('message'))
showMsgsuccess("{{ Session::get('message') }}")
@endif
@if(Session::has('error'))
showMsgError("{{ Session::get('error') }}")
@endif
</script>



    @yield('js')
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
@include("layouts.partials.css")
</head>

<body id="app-container" class="menu-default show-spinner">
 

@include("layouts.partials.header")

@if(Auth::user()->type==0) 
@include("layouts.partials.menuAdmin")
@elseif(Auth::user()->type==1 || Auth::user()->type==2 || Auth::user()->type==3 )
@include("layouts.partials.menuStore")
@else
@include("admin.layouts.partials.menuUsuario")
@endif
     



@yield('content')

@include("layouts.partials.js")
</body>
</html>
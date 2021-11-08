<div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li class="@if( (Request::is('administrador/*')) ) active @endif">
                        <a href="{{route('home')}}">
                            <i class="iconsmind-Shop-4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="@if( (Request::is('administrador/keyproyect')) || (Request::is('administrador/keyproyect/*')) || (Request::is('administrador/keyproduct')) || (Request::is('administrador/keyproduct/*')) || (Request::is('administrador/lenguajes')) || (Request::is('administrador/categorys')) || (Request::is('administrador/categorys/*')) || (Request::is('administrador/categorysproyects')) || (Request::is('administrador/categorysproyects/*')) ) active @endif">
                        <a href="#layouts">
                            <i class="iconsmind-Digital-Drawing"></i> Configuración
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="iconsmind-Email"></i>
                            <span>Configuración de Email</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="iconsmind-Paypal"></i>
                            <span>Configuración de PayPal</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="iconsmind-Add-User"></i>
                            <span>Representantes</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="iconsmind-Normal-Text"></i>
                            <span>Traducciones</span>
                        </a>
                    </li>

                    

                 
                </ul>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
         

                <ul class="list-unstyled" data-link="layouts">
                    <li class="@if( (Request::is('administrador/lenguajes')) ) active @endif">
                        <a href="{{route('administrador.lenguajes')}}">
                            <i class="simple-icon-credit-card"></i> Nuevo Idioma
                        </a>
                    </li>
                    <li  class="@if( (Request::is('administrador/categorys')) || (Request::is('administrador/categorys/*')) ) active @endif">
                        <a  href="{{route('administrador.categorys')}}">
                            <i class="simple-icon-list"></i> Categoria de Produtos
                        </a>
                    </li>
                    <li class="@if( (Request::is('administrador/keyproduct')) || (Request::is('administrador/keyproduct/*')) ) active @endif">
                        <a href="{{route('administrador.keyproduct')}}">
                            <i class="simple-icon-grid"></i> Etiquetas de Produtos
                        </a>
                    </li>
                    <li class="@if( (Request::is('administrador/categorysproyects')) || (Request::is('administrador/categorysproyects/*')) ) active @endif">
                        <a href="{{route('administrador.categorysproyects')}}">
                            <i class="simple-icon-book-open"></i> Categoria de Proyectos
                        </a>
                    </li>
                    <li class="@if( (Request::is('administrador/keyproyect')) || (Request::is('administrador/keyproyect/*')) ) active @endif">
                        <a  href="{{route('administrador.keyproyect')}}">
                            <i class="simple-icon-magnifier"></i> Etiquetas de Proyectos
                        </a>
                    </li>
                </ul>
           
 
            </div>
        </div>
    </div>
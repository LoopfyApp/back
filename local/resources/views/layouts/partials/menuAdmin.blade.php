<div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li class="@if(Request::routeIs('admin.home')) active @endif">
                        <a href="{{route('admin.home')}}" class="active">
                            <i class="iconsmind-Shop-4"></i>
                            <span>{{__('menu.dashboard')}}</span>
                        </a>
                    </li>
                    <li class="@if( Request::routeIs('species.index') || Request::routeIs('breed.index') || Request::routeIs('category.index') || Request::routeIs('trademarks.index') || Request::routeIs('subcategory.index') ) active @endif">
                        <a href="#layouts">
                            <i class="iconsmind-Digital-Drawing"></i> {{__('menu.configuration')}}
                        </a>
                    </li> 

                    

                 
                </ul>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
         

                <ul class="list-unstyled" data-link="layouts">
                    <li class="@if(Request::routeIs('species.index')) active @endif">
                        <a href="{{ route('species.index') }}">
                            <i class="iconsmind-Dog"></i> {{__('menu.species_category')}}
                        </a>
                    </li>
                    <li  class="@if(Request::routeIs('category.index')) active @endif">
                        <a  href="{{ route('category.index') }}">
                            <i class="simple-icon-list"></i> {{__('menu.product_category')}}
                        </a>
                    </li>
                    <li class="@if(Request::routeIs('subcategory.index')) active @endif">
                        <a href="{{ route('subcategory.index') }}">
                            <i class="iconsmind-Bulleted-List"></i> {{__('menu.product_sub_category')}} 
                        </a>
                    </li>
                    <li class="@if(Request::routeIs('trademarks.index')) active @endif">
                        <a href="{{ route('trademarks.index') }}">
                            <i class="simple-icon-book-open"></i>  {{__('menu.trademarks')}} 
                        </a>
                    </li>
                    <li class="@if(Request::routeIs('breed.index')) active @endif">
                        <a  href="{{ route('breed.index') }}">
                            <i class="simple-icon-organization"></i> {{__('menu.breed')}} 
                        </a>
                    </li>
                </ul>
           
 
            </div>
        </div>
    </div>

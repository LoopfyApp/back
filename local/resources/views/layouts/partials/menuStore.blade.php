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
                    <li class="@if( Request::routeIs('business.profile.index') || Request::routeIs('business.profile.bank.index')     ) active @endif">
                        <a href="#layouts">
                            <i class="iconsmind-Digital-Drawing"></i> {{__('menu.configuration')}}
                        </a>
                    </li> 

                    
                    <li class="@if(Request::routeIs('business.services.index') || Request::routeIs('business.services.add') || Request::routeIs('business.services.edit') ) active @endif">
                        <a href="{{route('business.services.index')}}"  >
                            <i class="iconsmind-Add-Window"></i>
                            <span>{{__('menu.service')}}</span>
                        </a>
                    </li>


                          
                    <li class="@if(Request::routeIs('business.veterinary.index') || Request::routeIs('business.veterinary.add') || Request::routeIs('business.veterinary.edit') ) active @endif">
                        <a href="{{route('business.veterinary.index')}}"  >
                            <i class="iconsmind-Add-Window"></i>
                            <span>{{__('menu.veterinary')}}</span>
                        </a>
                    </li>     
                    <li class="@if(Request::routeIs('business.products.index') || Request::routeIs('business.products.add') || Request::routeIs('business.products.edit') ) active @endif">
                        <a href="{{route('business.products.index')}}"  >
                            <i class="iconsmind-Add-Cart"></i>
                            <span>{{__('menu.productos')}}</span>
                        </a>
                    </li>

                                
                    <li class="@if(Request::routeIs('business.agenda.index') ) active @endif">
                        <a href="{{route('business.agenda.index')}}"  >
                            <i class="iconsmind-Alarm-Clock"></i>
                            <span>{{__('menu.agenda')}}</span>
                        </a>
                    </li>

                           
                    <li class="@if(Request::routeIs('business.sales.index') ) active @endif">
                        <a href="{{route('business.sales.index')}}"  >
                            <i class="iconsmind-Bank"></i>
                            <span>{{__('menu.misventas')}}</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
         

                <ul class="list-unstyled" data-link="layouts">
                    <li class="@if(Request::routeIs('business.profile.index')) active @endif">
                        <a href="{{ route('business.profile.index') }}">
                            <i class="iconsmind-Gear-2"></i> {{__('menu.profile')}}
                        </a>
                    </li> 
                    <li class="@if(Request::routeIs('business.profile.bank.index')) active @endif">
                        <a href="{{ route('business.profile.bank.index') }}">
                            <i class="iconsmind-Gear-2"></i> {{__('menu.account')}}
                        </a>
                    </li> 
                </ul>
           
 
            </div>
        </div>
    </div>

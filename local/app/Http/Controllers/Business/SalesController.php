<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $datos = array('title' => trans('menu.misventas'), 'subtitles' => trans('menu.misventas'));
 
        return view('business.sales.index')->with(['datos' => $datos]);
    }
}

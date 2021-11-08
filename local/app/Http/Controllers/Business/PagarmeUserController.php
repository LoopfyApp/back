<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\ListBank;
use App\Models\UserBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagarmeUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $listBank = ListBank::where('code', '!=', 'n/a')->orderby('code', 'asc')->get();
        $banco = UserBank::where('users_id', Auth::user()->id)->where('status', 0)->first();
        $datos = array('title' => trans('menu.dashboard'), 'subtitles' => trans('menu.account'));
        return view('business.profile.bank.index')->with(['listBank' => $listBank, 'datos' => $datos, 'banco' => $banco]);
    }

    public function createaccount(Request $request)
    {
        $data = new UserBank;
        $data->bank_code = $request->bank;
        $data->agencia = $request->bank_conde;
        $data->agencia_dv = $request->number_bank;
        $data->conta =  $request->account_bank;
        $data->conta_dv = $request->number_account_bank;
        $data->document_number =   $request->number_document;
        $data->legal_name =   $request->legal_name;
        $data->type =   $request->type_bank;
        $data->document_type = $request->type_number;
        $data->code_account = Auth::user()->id;
        $data->recipient_id = Auth::user()->id;
        $data->users_id = Auth::user()->id;
        $data->status = 0;
        $data->save();

        return redirect()->route('business.profile.bank.index')->with('message', 'Datos Registrado Correctamente');
    }
}

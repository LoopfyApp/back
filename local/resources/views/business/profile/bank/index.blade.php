@extends('layouts.index')
@section('title') {{__('account.title')}} @endsection


@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css" />

@endsection

@section('content')
<main>


    <div class="container-fluid">
        @include('layouts.partials.breadcrumb', ['info' => $datos])

        <div class="row">
            <div class="col-12">

                <div class="card mb-4">

                    <div class="card-body">

@if($banco)
{{__('account.title')}} 

<table id="table_services" class="table display responsive nowrap" style="width:100% !important">
                                <thead>
                                    <tr>
                               
                                        <th>{{__('account.type_number')}}</th>
                                        <th>{{__('account.number')}}</th> 
                                        <th>{{__('account.legal_name')}}</th>
                                        <th>{{__('account.number_account_bank')}}</th> 
                                        <th>{{__('account.bank')}}</th> 
                                        <th data-priority="1">{{__('products.label_options')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr  style="text-transform:uppercase">
                                <td>{{$banco->document_type}}</td>
                                <td>{{$banco->document_number}}</td>
                                <td>{{$banco->legal_name}}</td>
                                <td>{{$banco->document_number}}</td>
                                <td>
                                ({{$banco->listbanco->code}})-{{$banco->listbanco->name}}
                                <br>
                                {{$banco->conta_dv}}<br>
                                {{$banco->type}}
                                </td>
                                <td></td>
                                </tr>
                                </tbody>
                            </table>
@else
                        <form method="POST">
                            @csrf
                            <div class="form-row">

                                <div class="form-group col-md-3 col-sm-12">
                                    <label>{{__('account.type_number')}}</label>
                                    <select name="type_number" id="type_number" class="form-control" required>
                                        <option value="cpf">CPF</option>
                                        <option value="cnpj">CNPJ</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{__('account.number')}}</label>
                                    <input type="text" maxlength="100" onkeypress="return valideKey(event);" name="number_document" id="number" class="form-control" required placeholder="{{__('account.number')}}">
                                </div>

                                <div class="form-group  col-md-5 col-sm-12">
                                    <label>{{__('account.legal_name')}}</label>
                                    <input type="text" name="legal_name" maxlength="30" id="legal_name" required class="form-control" placeholder="{{__('account.legal_name')}}">
                                </div>

                            </div>


                            <div class="form-row">

                                <div class="form-group col-md-6 col-sm-12">
                                    <label>{{__('account.bank')}}</label>
                                    <select name="bank" id="bank" class="form-control select2-single" required>
                                       
                                        @foreach($listBank as $banco)
                                        <option value="{{$banco->id}}">{{$banco->code}} - {{$banco->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label>{{__('account.bank_conde')}}</label>
                                    <input type="text"  maxlength="4"  onkeypress="return valideKey(event);" name="bank_conde" id="bank_conde" class="form-control" required placeholder="{{__('account.bank_conde')}}">
                                </div>


                                <div class="form-group col-md-3 col-sm-12">
                                    <label>{{__('account.number_bank')}}</label>
                                    <input type="text"   maxlength="1" onkeypress="return valideKey(event);" name="number_bank" id="number_bank" class="form-control"  placeholder="{{__('account.number_bank')}}">
                                </div>



                            </div>


                            <div class="form-row">

                                <div class="form-group col-md-5 col-sm-12">
                                    <label>{{__('account.account_bank')}}</label>
                                    <input type="text"  maxlength="13" onkeypress="return valideKey(event);" name="account_bank" id="account_bank" class="form-control" required placeholder="{{__('account.account_bank')}}">

                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label>{{__('account.type_bank')}}</label>
                                    <select class="form-control  select2-single" name="type_bank">
                                        <option value="conta_corrente">Conta corrente</option>
                                        <option value="conta_poupanca">Conta poupanca</option>
                                        <option value="conta_corrente_conjunta">Conta corrente conjunta</option>
                                        <option value="conta_poupanca_conjunta">Conta poupanca conjunta</option>


                                    </select>

                                </div>


                                <div class="form-group col-md-3 col-sm-12">
                                    <label>{{__('account.number_account_bank')}}</label>
                                    <input type="text"  maxlength="2"  onkeypress="return valideKey(event);" name="number_account_bank" id="number_account_bank" class="form-control" required placeholder="{{__('account.number_account_bank')}}">
                                </div>



                            </div>

                            <button type="submit" class="btn btn-primary mb-0"> {{__('account.save')}}</button>
                        </form>
@endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')

<script type="text/javascript">
    function valideKey(evt) {
        var code = (evt.which) ? evt.which : evt.keyCode;
        if (code == 8) { // backspace.
            return true;
        } else if (code >= 48 && code <= 57) { // is a number.
            return true;
        } else { // other keys.
            return false;
        }
    }
</script>


@endsection
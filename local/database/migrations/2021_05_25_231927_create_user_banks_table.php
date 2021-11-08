<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('users_id');
            $table->string('bank_code');
            $table->string('agencia'); 
            $table->string('agencia_dv'); 
            $table->string('conta'); 
            $table->string('conta_dv'); 
            $table->string('document_number'); 
            $table->string('document_type'); //cpf, cnpj
            $table->string('type'); //conta_corrente, conta_poupanca, conta_corrente_conjunta, conta_poupanca_conjunta
            $table->string('legal_name'); 
            $table->string('code_account'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_banks');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameContactsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('contacts', function (Blueprint $table) {
        $table->renameColumn('nome', 'name');
        $table->renameColumn('celular', 'phone');
        $table->renameColumn('cep', 'zipcode');
        $table->renameColumn('estado', 'state');
        $table->renameColumn('cidade', 'city');
        $table->renameColumn('bairro', 'neighbourhood');
        $table->renameColumn('rua', 'street');
        $table->renameColumn('numero', 'number');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('contacts', function (Blueprint $table) {
        $table->renameColumn('name', 'nome');
        $table->renameColumn('phone', 'celular');
        $table->renameColumn('zipcode', 'cep');
        $table->renameColumn('state', 'estado');
        $table->renameColumn('city', 'cidade');
        $table->renameColumn('neighbourhood', 'bairro');
        $table->renameColumn('street', 'rua');
        $table->renameColumn('number', 'numero');
      });
    }
}

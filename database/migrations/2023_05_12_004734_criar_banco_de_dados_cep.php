<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rua', 200);
            $table->string('complemento', 100)->nullable();
            // Poderia ser referência a uma tabela de bairros.
            $table->string('bairro', 100);
            // Está como "string" pois já vi números de endereços precedidos ou sucedidos de letras.
            $table->string('numero', 10);
            // 8 dígitos + hífen.
            // Posso acabar me arrependendo disso aqui não ser uma chave estrangeira.
            $table->string('cep', 9);
            // Referência fictícia.
            $table->integer('cidade_id');
            // Referência fictícia.
            $table->integer('estado_id');
            $table->timestamps();
            $table->softDeletes();

            $table->index('cep');
            $table->index('cidade_id');
            $table->index('estado_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

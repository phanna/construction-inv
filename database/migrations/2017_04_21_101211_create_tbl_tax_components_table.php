<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTaxComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tax_components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tax_rate_id');
            $table->string('component');
            $table->integer('tax_rate');
            $table->boolean('tax_status');
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
        Schema::drop('tbl_tax_components');
    }
}

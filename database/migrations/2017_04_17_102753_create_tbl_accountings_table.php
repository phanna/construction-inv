<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accountings', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('account_type_id');
			$table->integer('tax_id');	
			$table->string('account_code')->unique();
			$table->string('account_name');
			$table->text('account_description');
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
        Schema::drop('tbl_accountings');
    }
}

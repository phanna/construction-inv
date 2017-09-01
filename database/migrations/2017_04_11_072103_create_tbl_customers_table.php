<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('cotact_type_id');
			$table->string('contact_company');
			$table->string('fullname');
			$table->string('email');
			$table->string('mobile');
			$table->string('deskphone');
			$table->string('website');
			$table->string('address');
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
        Schema::drop('tbl_contacts');
    }
}

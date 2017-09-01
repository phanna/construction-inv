<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_item_details', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('item_id');
			$table->integer('inventory_type');
			$table->integer('account_id');
			$table->integer('tax_item_id');
			$table->float('unit_price');
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
        Schema::drop('tbl_item_details');
    }
}

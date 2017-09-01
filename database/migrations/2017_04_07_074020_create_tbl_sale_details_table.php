<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sale_details', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('sale_inv_id');
			$table->integer('item_id');
			$table->text('description');
			$table->float('qty');
			$table->float('unit_price');
			$table->float('discount');
			$table->integer('account_id');
			$table->integer('taxItem_id');
			$table->float('sub_total');
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
        Schema::drop('tbl_sale_details');
    }
}

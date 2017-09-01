<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSaleInvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sale_invs', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->integer('contact_id');
			$table->integer('currency_id');
			$table->integer('tax_id');
			$table->datetime('toDate');
			$table->datetime('dueDate');
			$table->string('invoice_no');
			$table->string('reference');
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
        Schema::drop('tbl_sale_invs',function (Blueprint $table) {
				$table->string('invoiceNumber');
			});
		
    }
}

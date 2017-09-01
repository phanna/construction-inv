<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxStatusToTblTaxRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_tax_rates', function (Blueprint $table) {
            //
			$table->string('tax_status')->after('tax_rate')->comment = "1 is default, 2 delete able";;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_tax_rates', function (Blueprint $table) {
            //
        });
    }
}

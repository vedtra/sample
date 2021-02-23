<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("company_id")->nullable(false)->comment("Refer to Company");
            $table->string("province_id",16)->nullable(false)->comment("Refer to Provice Table");
            $table->string("city_id",16)->nullable(false)->comment("Refer to City Table");
            $table->string("address",256)->nullable(false)->comment("address of this company");
            $table->string("website",156)->nullable(true)->comment("website or IG account");
            $table->string("contact_01",64)->nullable(false);
            $table->string("contact_02",64)->nullable(true);
            $table->string("bank_name",125)->nullable(true);
            $table->string("bank_account",255)->nullable(true);
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
        Schema::dropIfExists('company_details');
    }
}

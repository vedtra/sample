<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyOperationalHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_operational_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean("sunday")->default(true)->comment("If Sunday is Active");
            $table->boolean("monday")->default(true)->comment("If monday is Active");
            $table->boolean("tuesday")->default(true)->comment("If tuesday is Active");
            $table->boolean("wednesday")->default(true)->comment("If wednesday is Active");
            $table->boolean("friday")->default(true)->comment("If friday is Active");
            $table->boolean("saturday")->default(true)->comment("If saturday is Active");
            $table->time("start_at")->nullable(false);
            $table->time("endt_at")->nullable(false);
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
        Schema::dropIfExists('company_operational_hours');
    }
}

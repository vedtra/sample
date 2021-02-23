<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',64);
            $table->string('image');
            $table->boolean('is_active')->default(false);
            $table->integer('qty')->default(0);
            $table->integer('total_stock')->default(0);
            $table->string('notes',1024)->nullable(true);
            $table->integer('type_id')->comment("Refer to Transport Type");
            $table->integer('category_id')->comment("Refer to Transport Category");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport');
    }
}

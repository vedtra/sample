<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTableCompanyField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add Company ID for User
        // If company ID is Null it means user is a coniolabs company
        // If Is Banned or Not
        Schema::table('users', function($table) {
            $table->integer("company_id")->nullable(true)->comment("Refer to Company"); 
            $table->boolean("is_banned")->default(false)->comment("Is this user is banned or not");    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function($table) {
            $table->dropColumn(['company_id','is_banned']);
        });
    }
}

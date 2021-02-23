 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name",32)->comment("Eq: Rental Company, BarberShop, Spa etc");
            $table->string("notes",64)->comment("About this category");
            $table->string('code')->nullable(true);
            $table->string("icon")->nullable(true)->comment("Icon Category default Null");
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
        Schema::dropIfExists('company_category');
    }
}

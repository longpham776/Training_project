<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products',function(Blueprint $table){
            $table->string('product_id',20)->primary();
            $table->string('product_name',255)->nullable(false);
            $table->string('product_image',255)->nullable(true);
            $table->decimal('product_price',10,0)->nullable(false)->default(0);
            $table->tinyInteger('is_sales')->nullable(false)->default(1)->comment('0: Dừng bán hoặc dừng sản xuất, 1: Có hàng bán');
            $table->text('description')->nullable(true);
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
        //
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('company_id');//メーカー名
            $table->string('product_name');//商品名
            $table->integer('price');//価格
            $table->integer('stock');//在庫数
            $table->text('comment')->nullable(); // コメント
            $table->string('img_path')->nullable();;//商品画像
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
        Schema::dropIfExists('products');
    }
};

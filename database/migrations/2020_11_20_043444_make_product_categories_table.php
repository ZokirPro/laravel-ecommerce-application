<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            //product_id
            $table->unsignedBigInteger('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete("cascade");
            //category_id
            $table->unsignedBigInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign("product_id");
            $table->dropColumn("product_id");

            $table->dropForeign("category_id");
            $table->dropForeign("category_id");
        });
    }
}

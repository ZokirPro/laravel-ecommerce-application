<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignConstraintProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            //drop foreign keys
            $table->dropForeign(['product_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn("product_id");
            $table->dropColumn("category_id");
            //recreating foreign keys
            /* $table->unsignedBigInteger('product_id')->unsigned()->index();
            $table->foreign('product_id')->nullable()->constrained("products");
            $table->unsignedBigInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->nullable()->constrained("categories"); */
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
            
            $table->dropColumn("product_id");
            $table->dropColumn("category_id");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'rate_point')) {
                $table->dropColumn('rate_point');
            }
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
            $table->string('photo')->nullable();
            $table->decimal('rate', '2', '1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'rate',
                'photo',
            ]);

            $table->string('image');
            $table->decimal('rate_point', '1', '1');
        });
    }
}

<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
           CREATE TRIGGER review_AFTER_INSERT AFTER INSERT ON product_reviews
           FOR EACH ROW
           BEGIN
               DECLARE rating double;

               SELECT AVG(rate) INTO rating 
               FROM product_reviews
               WHERE product_id = NEW.product_id;

               UPDATE products
               SET rate = rating
               WHERE id = NEW.product_id;
           END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TRIGGER IF EXISTS review_AFTER_INSERT');
    }
}

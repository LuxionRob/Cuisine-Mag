<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        $products = Product::all();
        foreach ($categories as $category) {
            $randomProducts = $products->random(rand(1, 5));
            foreach ($randomProducts as $product) {
                DB::table('categories_products')->insert([
                    'category_id' => $category->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}

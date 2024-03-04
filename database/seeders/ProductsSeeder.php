<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        products::truncate();

        foreach(range(1,30) as $range){
            products::create([
                'Product_name'=>'product'.$range,
                'section_id' =>  $range,
                'description' => 'description' .$range,
             
            ]);
           }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class PouductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products=[
            ['product1','100','30'],
            ['product2','150','70'],
            ['product3','40','90'],
            ['product4','70','50'],
            ['product5','400','50'],
            ['product6','700','60'],
        ];


        foreach ($products as $product)
            {
                Product::create([
                    'name'=>$product[0],
                    'price'=>$product[1],
                    'stock'=>$product[2],
                ]);
            }

    }
}

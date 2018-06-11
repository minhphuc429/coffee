<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->delete();
        \DB::table('products')->insert([
            [
                'name' => 'Classic Phin Freeze',
                'price' => 49000,
                'category_id' => 1
            ],
            [
                'name' => 'Freeze trà xanh',
                'price' => '49000',
                'category_id' => 2
            ],
            [
                'name' => 'Cookies & cream',
                'price' => 49000,
                'category_id' => 2
            ],
            [
                'name' => 'Phin Sữa Đá',
                'price' => 29000,
                'category_id' => 3
            ],
            [
                'name' => 'Phin Đen Đá',
                'price' => 29000,
                'category_id' => 3
            ],
            [
                'name' => 'Phin đen nóng',
                'price' => 29000,
                'category_id' => 3
            ],
            [
                'name' => 'Trà sen vàng',
                'price' => 39000,
                'category_id' => 4
            ],
            [
                'name' => 'Trà thạch đào',
                'price' => 39000,
                'category_id' => 4
            ],
            [
                'name' => 'Trà thạch vải',
                'price' => 39000,
                'category_id' => 4
            ],
            [
                'name' => 'Trà xanh đậu đỏ',
                'price' => 39000,
                'category_id' => 4
            ],
        ]);
    }
}

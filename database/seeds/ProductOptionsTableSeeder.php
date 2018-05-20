<?php

use Illuminate\Database\Seeder;

class ProductOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_options')->delete();
        \DB::table('product_options')->insert([
            [
                'product_id' => 1,
                'key' => 'size',
                'value' => 'Size M',
                'surcharge' => 0
            ],
            [
                'product_id' => 1,
                'key' => 'size',
                'value' => 'Size L',
                'surcharge' => 10000
            ],
            [
                'product_id' => 2,
                'key' => 'size',
                'value' => 'Size M',
                'surcharge' => 0
            ],
            [
                'product_id' => 2,
                'key' => 'size',
                'value' => 'Size L',
                'surcharge' => 10000
            ],
            [
                'product_id' => 3,
                'key' => 'size',
                'value' => 'Size M',
                'surcharge' => 0
            ],
            [
                'product_id' => 3,
                'key' => 'size',
                'value' => 'Size L',
                'surcharge' => 10000
            ],
            [
                'product_id' => 4,
                'key' => 'size',
                'value' => 'Size M',
                'surcharge' => 0
            ],
            [
                'product_id' => 4,
                'key' => 'size',
                'value' => 'Size L',
                'surcharge' => 6000
            ],
            [
                'product_id' => 5,
                'key' => 'size',
                'value' => 'Size M',
                'surcharge' => 0
            ],
            [
                'product_id' => 5,
                'key' => 'size',
                'value' => 'Size L',
                'surcharge' => 6000
            ],
            [
                'product_id' => 6,
                'key' => 'size',
                'value' => 'Size M',
                'surcharge' => 0
            ],
            [
                'product_id' => 6,
                'key' => 'size',
                'value' => 'Size L',
                'surcharge' => 6000
            ],
        ]);
    }
}

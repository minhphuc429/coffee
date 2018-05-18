<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();
        \DB::table('categories')->insert([
            [
                'name' => 'PHIN FREEZE'
            ],
            [
                'name' => 'FREEZE KHÔNG CÀ PHÊ'
            ],
            [
                'name' => 'CÀ PHÊ'
            ],
            [
                'name' => 'TRÀ'
            ]
        ]);
    }
}

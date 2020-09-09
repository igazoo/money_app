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
        //
        DB::table('categories')->insert([

            ['name' => '食費'],
            ['name' => '飲み会'],
            ['name' => '遊び'],
            ['name' => '買い物'],
            ['name' => 'デート'],
        ]);
    }
}

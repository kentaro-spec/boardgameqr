<?php

use Illuminate\Database\Seeder;

class BoardgamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('boardgames')->truncate(); 
        DB::table('boardgames')->insert([
            'name' => 'カタン',
        ]);
        DB::table('boardgames')->insert([
            'name' => 'ドミニオン',
        ]);
        DB::table('boardgames')->insert([
            'name' => 'カルカソンヌ',
        ]);
        DB::table('boardgames')->insert([
            'name' => '宝石の煌き',
        ]);
        DB::table('boardgames')->insert([
            'name' => 'ウボンゴ',
        ]);
    }
}

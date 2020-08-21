<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChangeDictionary extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('changes_dictionary')->insert([
            ['id' => '1', 'change_text' => 'Утро'],
            ['id' => '2', 'change_text' => 'День'],
            ['id' => '3', 'change_text' => 'Ночь'],
        ]);
    }
}

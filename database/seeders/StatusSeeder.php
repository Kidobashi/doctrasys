<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('status')->insert([
            'name' => 'Circulating'
        ]);

        DB::table('status')->insert([
            'name' => 'Received'
        ]);

        DB::table('status')->insert([
            'name' => 'Processing'
        ]);

        DB::table('status')->insert([
            'name' => 'Forward'
        ]);

        DB::table('status')->insert([
            'name' => 'Sent Back'
        ]);

        DB::table('status')->insert([
            'name' => 'Fixed'
        ]);
    }
}

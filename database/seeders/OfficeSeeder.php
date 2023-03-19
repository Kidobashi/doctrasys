<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->insert([
            'officeName' => 'MIS',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Office of the President',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Public Relations and Information Office',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Human Resource and Management Office',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Research Office',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'CMU PRESS',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => "University Registrar’s Office",
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'International Relations Office',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Supply and Property Management Office',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Alumni Relations & Linkages Office',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Office of Student Affairs',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'Office of the Registrar',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Agriculture',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Arts and Sciences',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Business and Management',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Education',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Engineering',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College Forestry and Environmentmental Science',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Human Ecology',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Information Sciences and Computing',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Nursing',
            'status' => '1'
        ]);

        DB::table('offices')->insert([
            'officeName' => 'College of Veterinary Medicine',
            'status' => '1'
        ]);
    }
}

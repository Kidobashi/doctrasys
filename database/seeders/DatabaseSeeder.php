<?php

namespace Database\Seeders;

use App\Models\LackingDocuments;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            StatusSeeder::class,
            DocumentTypeSeeder::class,
            LackingDocuments::class,
            OfficeSeeder::class,
            PrimaryReasonSeeder::class,
            RoleSeeder::class,
            RoleUserSeeder::class,
        ]);
    }
}

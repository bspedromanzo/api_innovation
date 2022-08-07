<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collaborators')->insert([
            'name' => 'Superadmin',
            'type' => 'superadmin',
            'email' => 'super@gmail.com',
            'password' => Crypt::encrypt(101010)
        ]);

        DB::table('marks')->insert([
            'name' => 'Gigabyte',
        ]);

        DB::table('marks')->insert([
            'name' => 'Asus',
        ]);

        DB::table('marks')->insert([
            'name' => 'AMD',
        ]);

        DB::table('marks')->insert([
            'name' => 'Intel',
        ]);

        DB::table('marks')->insert([
            'name' => 'CoolerMaster',
        ]);
    }
}

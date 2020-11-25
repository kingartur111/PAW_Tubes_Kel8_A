<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')
            ->insert([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '$2b$10$PztJqRN.6GUmQbVarHaEZ.xxDuoIbz8yYjmFBH65ZRCMVsjZLTDoK',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ]);
    }
}

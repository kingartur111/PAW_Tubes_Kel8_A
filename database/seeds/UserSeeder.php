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
                'password' => '$2b$10$5QPvD/zCLGRT5nhx38wA0eWYzsK.QwdWGNiDqTpVUkRB.68yRo9ni', // pass: bangko12
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ]);
    }
}

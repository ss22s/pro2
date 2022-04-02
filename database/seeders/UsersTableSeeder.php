<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('users')->insert([
            'name' => 'タロ',
            'email' => 'aaa@bbb.com',
            'password' => bcrypt('pass'),
            'tickets_number' => 1234567890,
            'birthday' => '2000-01-01',
        ]);
    }
}

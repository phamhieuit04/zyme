<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $editors = collect([]);
            for ($i = 0; $i < 100; $i++) {
                $editors->push([
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => Hash::make('12345678'),
                    'role' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            DB::table('users')->insert($editors->toArray());

            DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}

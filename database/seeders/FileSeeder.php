<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $files = collect([]);
            for ($i = 0; $i < 1000; $i++) {
                $files->push([
                    'filename' => 'fileame-' . $i . '.jpeg',
                    'deadline' => now()->addDay(),
                    'status' => 1,
                    'priority' => 1,
                    'user_id' => rand(2, 100),
                    'synchronize' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            DB::table('files')->insert($files->toArray());
        });
    }
}

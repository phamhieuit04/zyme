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
        // Tao 1000 ban ghi bang file
        $files = collect([]);
        for ($i = 0; $i < 1000; $i++) {
            $files->push([
                'filename' => 'fileame-' . $i . '.jpeg',
                'deadline' => now(), // Lay thoi gian hien tai
                'status' => 1,
                'priority' => 1,
                'user_id' => rand(2, 100),
                'synchronize' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        // Debug trong Laravel,
        try {
            // Tao 1 yeu cau giao dich voi CSDL
            DB::beginTransaction();
            // Khi thao tac cua yeu cau thanh cong thi moi cap nhat du lieu
            DB::table('files')->insert($files->toArray());
            // Tien hanh xu ly du lieu
            DB::commit();
        } catch (\Exception $e) {
            // Neu thao tac giao dich vs CSDL that bai
            // Tien hanh rollback ve du lieu cu
            DB::rollBack();
            dd($e);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('guru')->insert([
            [
               [
                'NIP' => '191001',
                'nama_guru' => 'Pak Andi',
                'jabatan' => 'Kepala Sekolah',
                'tgl_lahir' => '1985-01-01',
                'password' => Hash::make(date('dmY', strtotime('1985-01-01'))),
            ],

            ],
            [
                'NIP' => '19870102002',
                'nama_guru' => 'Bu Sari',
                'jabatan' => 'Wali Kelas',
                'tgl_lahir' => '1987-02-02',
                'password' => Hash::make(date('dmY', strtotime('1987-02-02'))),
            ],
            [
                'NIP' => '19890203003',
                'nama_guru' => 'Admin Aplikasi',
                'jabatan' => 'Admin',
                'tgl_lahir' => '1989-03-03',
                'password' => Hash::make(date('dmY', strtotime('1989-03-03'))),
            ],
        ]);
    }
}

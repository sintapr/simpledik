<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'NIS' => '12348',
                'NISN' => '99887766',
                'NIK' => '3210001',
                'nama_siswa' => 'Budi Santoso',
                'tempat_lahir' => 'Bandung',
                'tgl_lahir' => '2010-05-12',
                'nama_kelas' => '7A',
                'foto' => null,
                'password' => Hash::make(date('dmY', strtotime('2010-05-12'))),
            ],
        ]);
    }
}

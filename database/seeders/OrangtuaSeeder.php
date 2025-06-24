<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Orangtua;
use Carbon\Carbon;

class OrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaList = Siswa::all();
        $counter = 1;

        foreach ($siswaList as $siswa) {
            // Generate ID Ortu OT001, OT002, ...
            $idOrtu = 'OT' . str_pad($counter, 3, '0', STR_PAD_LEFT);

            Orangtua::create([
                'id_ortu' => $idOrtu,
                'NIS' => $siswa->NIS,
                'nama_ayah' => 'Ayah ' . $siswa->nama_siswa,
                'nama_ibu' => 'Ibu ' . $siswa->nama_siswa,
                'pekerjaan_ayah' => 'Karyawan',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'alamat' => 'Alamat ' . $siswa->nama_siswa,
                'password' => Hash::make(Carbon::parse($siswa->tgl_lahir)->format('dmY')),
            ]);

            $counter++;
        }
    }
}

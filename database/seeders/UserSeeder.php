<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Koordinator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $koor = User::create([
            'username' => 'Yetli Oslan',
            'password' => Hash::make('12345678'),
            'role'     => 'koordinator'
        ]);
        Koordinator::create([
            'id_user' => $koor->id_user,
            'nama_koordinator' => 'Yetli Oslan, S.Kom, M.T.',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Aloysius Airlangga',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Aloysius Airlangga Bajuadji, S.Kom., M.Eng.',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Andhika Galuh',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Andhika Galuh Prabawati, S.Kom., M.Kom.',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Andreas Satyo',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Andreas Satyo Aji Nugroho, S.Kom.',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Argo Wibowo',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Argo Wibowo, S.T., M.T.',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Lussy Ernawati',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Lussy Ernawati, S.Kom., M.Acc',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Wilson Nasumi',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Wilson Nasumi Mili, S.Kom., M.T.',
            'no_telp' => $faker->numerify('08##########')
        ]);

        $dosen = User::create([
            'username' => 'Yetli Oslan',
            'password' => Hash::make('dosen123'),
            'role'     => 'dosen'
        ]);
        Dosen::create([
            'id_user' => $dosen->id_user,
            'nama_dosen' => 'Yetli Oslan, S.Kom, M.T.',
            'no_telp' => $faker->numerify('08##########')
        ]);
    }
}

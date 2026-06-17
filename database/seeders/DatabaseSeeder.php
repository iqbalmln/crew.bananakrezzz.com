<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\card;
use App\Models\card_level;
use App\Models\marketing;
use App\Models\setting;
use App\Models\store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama'=>'Staf BK',
            'hp'=>'983249239',
            'username'=>'bk',
            'level'=>'staf',
            'store_id'=>'3',
            'password'=>'bcrypt'('123'),
        ]);
        // User::create([
        //     'nama'=>'dio',
        //     'hp'=>'0982384832',
        //     'username'=>'dio',
        //     'level'=>'marketing',
        //     'password'=>'bcrypt'('123'),
        // ]);
        // User::create([
        //     'nama'=>'riki',
        //     'hp'=>'0982384832',
        //     'username'=>'riki',
        //     'level'=>'marketing',
        //     'password'=>'bcrypt'('123'),
        // ]);
        User::create([
            'nama'=>'Admin',
            'store_id'=>2,
            'hp'=>'0982384832',
            'username'=>'admin',
            'level'=>'admin',
            'password'=>'bcrypt'('123'),
        ]);
        User::create([
            'nama'=>'Master',
            'store_id'=>0,
            'hp'=>'0982384832',
            'username'=>'master',
            'level'=>'master',
            'password'=>'bcrypt'('123'),
        ]);
        marketing::create([
            'store_id'=>2,
            'nama'=>'Doni',
            'hp'=>'829348',
            
        ]);
        card_level::create([
            'nama'=>'SILVER',
        ]);
        card_level::create([
            'nama'=>'GOLD',
        ]);
        card_level::create([
            'nama'=>'PLATINUM',
        ]);
        store::create([
            'nama'=>'Banana Krezzz',
            'alamat'=>'Raya Solo - Tawangmangu, Gedangan, Salam,
            Karangpandan, Karanganyar, Jawa Tengah 57791',
        ]);
        store::create([
            'nama'=>'Banana Krezzz Cabang Bali Ole',
            'alamat'=>'Karanganyar, Jawa Tengah 57791',
        ]);
        store::create([
            'nama'=>'Banana Krezzz Cabang Subang',
            'alamat'=>'Subang, Jawa Barat 57791',
        ]);
        store::create([
            'nama'=>'Banana Krezzz Cabang Sarangan',
            'alamat'=>'Sarangan, Jawa Timur 57791',
        ]);
        setting::create([
            'belanja'=>500000,
            'min_presensi'=>1,
        ]);
        
    }
}

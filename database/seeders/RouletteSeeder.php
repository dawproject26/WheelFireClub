<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouletteSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            'VOCAL', 'VOCAL',
            'CONSONANTE', 'CONSONANTE',
            'ELEVEN',
            'VECNA',
            'DEMOGORGON',
            'DEMOPERRO'
        ];

        foreach ($options as $option) {
            DB::table('roulette')->insert([
                'option' => $option
            ]);
        }
    }
}

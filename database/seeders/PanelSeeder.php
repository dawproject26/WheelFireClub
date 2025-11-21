<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Panel;
use App\Models\Phrase;

class PanelSeeder extends Seeder
{
    public function run(): void
    {
        $panel = Panel::create([
            'name' => 'Panel 1'
        ]);

        $phrases = [
            'HOLA MUNDO',
            'PROGRAMAR ES DIVERTIDO',
            'LARAVEL DOCE ES POTENTE',
            'WHEELFIRECLUB'
        ];

        foreach ($phrases as $phrase) {
            Phrase::create([
                'panel_id' => $panel->id,
                'phrase'   => $phrase
            ]);
        }
    }
}

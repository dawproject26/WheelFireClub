<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanelSeeder extends Seeder
{
    public function run(): void
    {
        $phrases = [
            ['movie' => '300', 'phrase' => 'ESTO ES ESPARTA'],
            ['movie' => 'MATRIX', 'phrase' => 'YO SOLO PUEDO MOSTRARTE LA PUERTA TU ERES QUIEN LA TIENE QUE ATRAVESAR'],
            ['movie' => 'TERMINATOR', 'phrase' => 'SAYONARA BABY'],
            ['movie' => 'GLADIATOR', 'phrase' => 'MI NOMBRE ES MAXIMO DECIMO MERIDIO'],
            ['movie' => 'KARATE KID', 'phrase' => 'DAR CERA PULIR CERA'],
            ['movie' => 'STAR WARS', 'phrase' => 'LUKE YO SOY TU PADRE'],
            ['movie' => 'TOY STORY', 'phrase' => 'HAY UNA SERPIENTE EN MI BOTA'],
            ['movie' => 'STAR WARS', 'phrase' => 'HAZLO O NO LO HAGAS PERO NO LO INTENTES'],
            ['movie' => 'EL RESPLANDOR', 'phrase' => 'AQUI ESTA JOHNNY'],
            ['movie' => 'LOS SIMPSONS', 'phrase' => 'SIN TELE Y SIN CERVEZA HOMER PIERDE LA CABEZA'],
            ['movie' => 'EL CLUB DE LOS POETAS MUERTOS', 'phrase' => 'OH CAPITAN MI CAPITAN'],
            ['movie' => 'FROZEN', 'phrase' => 'HAY PERSONAS POR LAS QUE MERECE LA PENA DERRETIRSE'],
            ['movie' => 'EL REY LEON', 'phrase' => 'TODO LO QUE TOCA LA LUZ ES NUESTRO REINO'],
            ['movie' => 'TIBURON', 'phrase' => 'NECESITAREMOS OTRO BARCO MAS GRANDE'],
            ['movie' => 'APOCALIPSE NOW', 'phrase' => 'ME ENCANTA EL OLOR A NAPALM POR LA MANANA'],
            ['movie' => 'LOS JUEGOS DEL HAMBRE', 'phrase' => 'ME PRESENTO VOLUNTARIA COMO TRIBUTO'],
            ['movie' => 'EL VIAJE DE CHIHIRO', 'phrase' => 'NADA DE LO QUE SUCEDE SE OLVIDA JAMAS'],
            ['movie' => 'AQUI NO HAY QUIEN VIVA', 'phrase' => 'UN POQUITO DE POR FAVOR'],
            ['movie' => 'INTERSTELLAR', 'phrase' => 'EL AMOR ES LA UNICA FUERZA TRASCENDENTAL'],
            ['movie' => 'LA LLEGADA', 'phrase' => 'EL LENGUAJE MOLDEA NUESTRA REALIDAD'],
            ['movie' => 'EL DIARIO DE NOA', 'phrase' => 'NO PUEDES VIVIR TU VIDA PARA OTROS TIENES QUE HACER LO QUE ES CORRECTO PARA TI'],
            ['movie' => 'LA BELLA Y LA BESTIA', 'phrase' => 'EL AMOR NOS DA FUERZAS QUE NI IMAGINABAMOS TENER'],
            ['movie' => 'EL CURIOSO CASO DE BENJAMIN BUTTON', 'phrase' => 'NO SE TRATA DE CUANTO TIEMPO TENEMOS SINO DE COMO LO APROVECHAMOS']
        ];

        DB::table('phrases')->insert($phrases);
    }
}
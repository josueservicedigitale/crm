<?php


namespace Database\Seeders;

use App\Models\Parametre;
use Illuminate\Database\Seeder;

class ParametresSeeder extends Seeder
{
    public function run(): void
    {
        $parametres = [
            // ... (les mêmes paramètres que dans le contrôleur)
        ];

        foreach ($parametres as $param) {
            Parametre::create($param);
        }
    }
}
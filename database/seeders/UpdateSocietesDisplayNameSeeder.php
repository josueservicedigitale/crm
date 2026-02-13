<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Societe;
use Illuminate\Support\Facades\DB;

class UpdateSocietesDisplayNameSeeder extends Seeder
{
    public function run()
    {
        // Mise à jour des sociétés existantes
        $societes = [
            ['code' => 'nova', 'display_name' => 'Énergie Nova', 'template_folder' => 'nova'],
            ['code' => 'energie_nova', 'display_name' => 'Énergie Nova', 'template_folder' => 'nova'],
            ['code' => 'house', 'display_name' => 'MyHouse Solutions', 'template_folder' => 'house'],
            ['code' => 'myhouse', 'display_name' => 'MyHouse Solutions', 'template_folder' => 'house'],
            ['code' => 'patrimoine', 'display_name' => 'Patrimoine Immobilier', 'template_folder' => 'patrimoine'],
            ['code' => 'patrimoine_immobilier', 'display_name' => 'Patrimoine Immobilier', 'template_folder' => 'patrimoine'],
        ];

        foreach ($societes as $societe) {
            DB::table('societes')
                ->where('code', $societe['code'])
                ->update([
                    'display_name' => $societe['display_name'],
                    'template_pdf_folder' => $societe['template_folder'],
                ]);
        }

        $this->command->info('✅ Sociétés mises à jour avec display_name');
    }
}
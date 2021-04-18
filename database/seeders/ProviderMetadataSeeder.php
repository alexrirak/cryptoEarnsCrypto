<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderMetadataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provider_metadata')->insert([
            'id' => 'bd133c0b-8ebd-4517-9811-a474b16ec718',
            'name' => 'Celsius',
            'specialRateName' => 'Cel Rates',
            'notes' => 'Rates shown are international rates.',
            'referralUrl' => 'https://celsiusnetwork.app.link/190554d731'
        ]);
    }
}

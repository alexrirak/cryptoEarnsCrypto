<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeminiProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provider_metadata')->insert([
           'id' => '424ed7d3-37cb-4da2-84bb-859e05f3e8d6',
           'name' => 'Gemini',
           'updated_at' => Carbon::now()
       ]);
    }
}

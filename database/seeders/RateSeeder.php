<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => '32321a55-799c-440e-90b7-0d30dbfff8de',
            'rate' => 0.12,
            'source' => 'celsius'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => '32321a55-799c-440e-90b7-0d30dbfff8de',
            'rate' => 0.13,
            'source' => 'celsius'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => '32321a55-799c-440e-90b7-0d30dbfff8de',
            'rate' => 0.1,
            'source' => 'coinloan'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => 'ba1a3ab3-266c-46e2-afd8-e9080e4c6048',
            'rate' => 0.182,
            'source' => 'celsius'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => 'ba1a3ab3-266c-46e2-afd8-e9080e4c6048',
            'rate' => 0.19,
            'source' => 'celsius'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => 'ba1a3ab3-266c-46e2-afd8-e9080e4c6048',
            'rate' => 0.17,
            'source' => 'coinloan'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => 'dadc3116-d863-4f24-84db-ab198282ec1f',
            'rate' => 0.23,
            'source' => 'coinloan'
        ]);

        sleep(1);

        DB::table('rates')->insert([
            'id' => Uuid::uuid4(),
            'coin_id' => '5bfc635e-1919-430f-810f-4d28bf09e306',
            'rate' => 0.04,
            'source' => 'coinloan'
        ]);
    }
}

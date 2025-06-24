<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'External ID',
                'model' => null,
                'code' => 'x-external-id',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
    }
}

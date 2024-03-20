<?php

namespace Database\Seeders\Test\Admin\RailwayProvider;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixedSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('railway_provider_event_streams')->insert([
            'id' => 1,
        ]);
        DB::table('store_railway_provider_requests')->insert([
            'id' => 1,
            'token' => 'token',
            'railway_provider_event_stream_id' => '1',
            'name' => '鉄道会社',
        ]);
    }
}

<?php

namespace Perilune\Resources\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(NewsSeeder::class);
        $this->call(GuildsSeeder::class);

        Model::reguard();
    }
}

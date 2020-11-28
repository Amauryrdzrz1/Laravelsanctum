<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(userSeed::class);
        $this->call(productoSeed::class);
        $this->call(comentarioSeed::class);
    }
}

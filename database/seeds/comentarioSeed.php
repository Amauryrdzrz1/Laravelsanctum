<?php

use Illuminate\Database\Seeder;

class comentarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Comentarios::class, 100)->create();
    }
}

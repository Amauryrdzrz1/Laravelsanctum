<?php

use Illuminate\Database\Seeder;
use App\Productos;

class productoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Productos::class, 20)->create();
    }
}

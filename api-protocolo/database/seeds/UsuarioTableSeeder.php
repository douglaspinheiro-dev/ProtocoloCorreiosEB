<?php
use Illuminate\Database\Seeder;
class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 users using the user factory
        factory(App\Usuario::class, 10)->create();
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Administrador';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('contraseña');
        $user->save();
        $user->assignRole('Administrator');
    
        $user = new User;
        $user->name = 'Manianela';
        $user->email = 'secretaria@admin.com';
        $user->password = bcrypt('contraseña');
        $user->save();
        $user->assignRole('Secretary');

        $user = new User;
        $user->name = 'Ricardo Valdivia';
        $user->email = 'rvaldivi@uta.cl';
        $user->password = bcrypt('contraseña');
        $user->save();
        $user->assignRole('Profesor');

        $user = new User;
        $user->name = 'Roberto Silva';
        $user->email = 'roberto.silva@alumnos.uta.cl';
        $user->password = bcrypt('contraseña');
        $user->save();
        $user->assignRole('Student');

        $user = new User;
        $user->name = 'Bananon';
        $user->email = 'banana@admin.com';
        $user->password = bcrypt('contraseña');
        $user->save();
        $user->assignRole('Guest');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// SPATIE
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $permisos = [
                'ver-rol',
                'crear-rol',
                'editar-rol',
                'borrar-rol',
                'ver-usuario',
                'crear-usuario',
                'editar-usuario',
                'borrar-usuario',
                'ver-socio',
                'crear-socio',
                'editar-socio',
                'borrar-socio',
                'ver-persona',
                'crear-persona',
                'editar-persona',
                'borrar-persona',
                'ver-cargo',
                'crear-cargo',
                'editar-cargo',
                'borrar-cargo',
            ];

        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }
    }
}
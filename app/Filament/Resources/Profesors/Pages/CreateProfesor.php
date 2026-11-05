<?php

namespace App\Filament\Resources\Profesors\Pages;

use App\Filament\Resources\Profesors\ProfesorResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProfesor extends CreateRecord
{
    protected static string $resource = ProfesorResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // 1. Crea el usuario de login con rol profesor
        $user = User::create([
            'name' => $data['nombre'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'profesor',
        ]);

        // 2. Quita email y password (no son columnas de la tabla profesores)
        unset($data['email'], $data['password']);

        // 3. Crea el profesor ligado a ese usuario
        return $user->profesor()->create($data);
    }
}
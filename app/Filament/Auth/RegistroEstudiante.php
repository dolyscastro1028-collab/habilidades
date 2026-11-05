<?php

namespace App\Filament\Auth;

use App\Models\Role;
use Filament\Auth\Pages\Register;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class RegistroEstudiante extends Register
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNameFormComponent()->label('Nombre'),

            TextInput::make('identificacion')
                ->label('Identificación')
                ->required()
                ->unique('estudiantes', 'identificacion'),

            TextInput::make('edad')
                ->numeric()
                ->minValue(1)
                ->maxValue(120)
                ->required(),

            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // 1. Crea el usuario para iniciar sesión
        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => Role::idDe('estudiante'),
        ]);

        // 2. Crea el registro en la tabla estudiantes
        $user->estudiante()->create([
            'identificacion' => $data['identificacion'],
            'edad' => $data['edad'],
        ]);

        return $user;
    }
}
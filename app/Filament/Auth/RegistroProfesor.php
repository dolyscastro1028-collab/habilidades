<?php

namespace App\Filament\Auth;

use App\Models\Role;
use Filament\Auth\Pages\Register;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class RegistroProfesor extends Register
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNameFormComponent()
                ->label('Nombre completo'),

            TextInput::make('identificacion')
                ->label('Número de identificación')
                ->required()
                ->unique('profesores', 'identificacion'),

            TextInput::make('edad')
                ->label('Edad')
                ->numeric()
                ->minValue(1)
                ->maxValue(120)
                ->required(),

            TextInput::make('materia')
                ->label('Materia o área que enseña')
                ->required()
                ->maxLength(255),

            $this->getEmailFormComponent(),

            $this->getPasswordFormComponent(),

            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => Role::idDe('profesor'),
        ]);

        $user->profesor()->create([
            'nombre' => $data['name'],
            'identificacion' => $data['identificacion'],
            'edad' => $data['edad'],
            'materia' => $data['materia'],
        ]);

        return $user;
    }
}
<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;

// Datos de acceso (tabla users) en los formularios de estudiante y profesor del admin.
// Se guardan con el trait CuentaDeUsuario.
class CamposCuenta
{
    // Sección del formulario con los datos de acceso
    public static function seccion(): Section
    {
        return Section::make('Cuenta de acceso')
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->label('Nombre completo')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Correo para iniciar sesión')
                    ->email()
                    ->required()
                    ->unique('users', 'email', ignorable: fn (?Model $record) => $record?->user),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->required(fn (string $operation) => $operation === 'create')
                    ->dehydrated(fn (?string $state) => filled($state))
                    ->helperText(fn (string $operation) => $operation === 'edit' ? 'Déjala vacía para no cambiarla.' : null),
            ]);
    }
}

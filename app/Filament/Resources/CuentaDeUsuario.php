<?php

namespace App\Filament\Resources;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Estudiantes y profesores creados desde el admin necesitan una cuenta en `users`
 * para poder iniciar sesión. Este trait la crea / actualiza junto con el registro.
 *
 * Los campos del formulario están en CamposCuenta::seccion().
 * La página que lo usa define: protected static string $rol = 'estudiante' | 'profesor';
 * (el rol coincide con el nombre de la relación en User: $user->estudiante(), $user->profesor()).
 */
trait CuentaDeUsuario
{
    private static array $camposCuenta = ['name', 'email', 'password'];

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                ...Arr::only($data, self::$camposCuenta),
                'role_id' => Role::idDe(static::$rol),
            ]);

            return $user->{static::$rol}()->create(Arr::except($data, self::$camposCuenta));
        });
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return [...$data, 'name' => $this->record->user->name, 'email' => $this->record->user->email];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        DB::transaction(function () use ($record, $data) {
            $record->user->update(Arr::only($data, self::$camposCuenta));
            $record->update(Arr::except($data, self::$camposCuenta));
        });

        return $record;
    }
}

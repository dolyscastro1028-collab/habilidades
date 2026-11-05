@php
    use App\Filament\Estudiante\Resources\Cursos\CursoResource;

    $curso = $getRecord();
    $completadas = auth()->user()->estudiante->leccionesCompletadas()->pluck('lecciones.id');
@endphp

<div style="display: flex; flex-direction: column; gap: 1rem;">
    @forelse ($curso->modulos()->with('lecciones')->get() as $modulo)
        <x-filament::section :heading="'Módulo ' . $loop->iteration . ': ' . $modulo->titulo" collapsible>
            <ul style="display: flex; flex-direction: column; gap: 0.5rem;">
                @forelse ($modulo->lecciones as $leccion)
                    @php $hecha = $completadas->contains($leccion->id); @endphp
                    <li style="display: flex; align-items: center; gap: 0.5rem;">
                        <x-filament::icon
                            :icon="$hecha ? 'heroicon-s-check-circle' : 'heroicon-o-play-circle'"
                            style="width: 1.25rem; height: 1.25rem; {{ $hecha ? 'color: rgb(22 163 74);' : '' }}"
                        />
                        <x-filament::link :href="CursoResource::getUrl('leccion', ['record' => $curso, 'leccion' => $leccion])">
                            {{ $leccion->titulo }}
                        </x-filament::link>
                        @if ($hecha)
                            <x-filament::badge color="success" size="sm">Completada</x-filament::badge>
                        @endif
                    </li>
                @empty
                    <li>Este módulo aún no tiene lecciones.</li>
                @endforelse
            </ul>
        </x-filament::section>
    @empty
        <p>Este curso aún no tiene módulos.</p>
    @endforelse
</div>

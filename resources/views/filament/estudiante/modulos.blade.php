@php
    use App\Filament\Estudiante\Resources\Cursos\CursoResource;

    $curso = $getRecord();
    $estudiante = auth()->user()->estudiante;
    $inscrito = $curso->tieneInscrito($estudiante);
    $completadas = $estudiante->leccionesCompletadas()->pluck('lecciones.id');
@endphp

<div style="display: flex; flex-direction: column; gap: 1rem;">
    @unless ($inscrito)
        <div style="display: flex; align-items: center; gap: 0.6rem; padding: 0.75rem 1rem; border-radius: 0.75rem;
                    background: rgba(219, 39, 119, 0.1); border: 1px solid rgba(219, 39, 119, 0.35);">
            <x-filament::icon icon="heroicon-o-lock-closed" style="width: 1.25rem; height: 1.25rem; color: rgb(219 39 119); flex-shrink: 0;" />
            <span style="font-size: 0.9rem;">Este es el temario del curso. <strong>Inscríbete</strong> para abrir las lecciones y guardar tu avance.</span>
        </div>
    @endunless

    @forelse ($curso->modulos()->with('lecciones')->get() as $modulo)
        <x-filament::section :heading="'Módulo ' . $loop->iteration . ': ' . $modulo->titulo"
                             :description="$modulo->lecciones->count() . ' lecciones'" collapsible>
            <ul style="display: flex; flex-direction: column; gap: 0.5rem;">
                @forelse ($modulo->lecciones as $leccion)
                    @php $hecha = $completadas->contains($leccion->id); @endphp
                    <li style="display: flex; align-items: center; gap: 0.5rem;">
                        @if ($inscrito)
                            <x-filament::icon
                                :icon="$hecha ? 'heroicon-s-check-circle' : 'heroicon-o-play-circle'"
                                style="width: 1.25rem; height: 1.25rem; {{ $hecha ? 'color: rgb(22 163 74);' : '' }}" />
                            <x-filament::link :href="CursoResource::getUrl('leccion', ['record' => $curso, 'leccion' => $leccion])">
                                {{ $leccion->titulo }}
                            </x-filament::link>
                            @if ($hecha)
                                <x-filament::badge color="success" size="sm">Completada</x-filament::badge>
                            @endif
                        @else
                            <x-filament::icon icon="heroicon-o-lock-closed" style="width: 1.15rem; height: 1.15rem; opacity: 0.55;" />
                            <span style="opacity: 0.8;">{{ $leccion->titulo }}</span>
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

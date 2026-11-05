{{-- Tarjeta de curso del catálogo del estudiante (ViewColumn dentro de una cuadrícula) --}}
@php
    use Illuminate\Support\Facades\Storage;

    $curso = $getRecord();
    $estudiante = auth()->user()->estudiante;
    $inscrito = $curso->estudiantes->contains('id', $estudiante?->id);
    $progreso = $inscrito ? $estudiante->progresoEn($curso) : null;

    // Fondo de color cuando el curso no tiene portada (tonos de la marca)
    $fondos = [
        'linear-gradient(135deg, #db2777, #7c3aed)',
        'linear-gradient(135deg, #7c3aed, #2563eb)',
        'linear-gradient(135deg, #c026d3, #db2777)',
        'linear-gradient(135deg, #9333ea, #c026d3)',
    ];
    $fondo = $fondos[$curso->id % count($fondos)];
@endphp

<div style="display: flex; flex-direction: column; gap: 0.75rem; width: 100%;">
    {{-- Portada --}}
    <div style="position: relative; aspect-ratio: 16 / 9; max-height: 11rem; width: 100%; border-radius: 0.75rem; overflow: hidden; background: {{ $fondo }};">
        @if ($curso->portada)
            <img src="{{ Storage::disk('public')->url($curso->portada) }}" alt="Portada de {{ $curso->nombre }}"
                 style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.9);">
                <x-filament::icon icon="heroicon-o-academic-cap" style="width: 2.75rem; height: 2.75rem;" />
            </div>
        @endif

        <span style="position: absolute; top: 0.75rem; left: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 9999px;
                     background: rgba(0,0,0,0.55); color: #fff; font-size: 0.75rem; font-weight: 600;">
            {{ $curso->materia }}
        </span>

        @if ($inscrito)
            <span style="position: absolute; top: 0.75rem; right: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 9999px;
                         background: rgb(22 163 74); color: #fff; font-size: 0.75rem; font-weight: 600;">
                Inscrito
            </span>
        @endif
    </div>

    {{-- Datos --}}
    <div>
        <h3 style="font-size: 1.05rem; font-weight: 700; line-height: 1.3;">{{ $curso->nombre }}</h3>
        <p style="font-size: 0.875rem; opacity: 0.75; margin-top: 0.15rem;">
            {{ $curso->profesor?->nombre ?? 'Sin profesor' }}
        </p>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; font-size: 0.8rem; opacity: 0.8;">
        <span style="display: inline-flex; align-items: center; gap: 0.25rem;">
            <x-filament::icon icon="heroicon-o-rectangle-stack" style="width: 1rem; height: 1rem;" />
            {{ $curso->modulos_count }} módulos
        </span>
        <span style="display: inline-flex; align-items: center; gap: 0.25rem;">
            <x-filament::icon icon="heroicon-o-play-circle" style="width: 1rem; height: 1rem;" />
            {{ $curso->lecciones_count }} lecciones
        </span>
        <span style="display: inline-flex; align-items: center; gap: 0.25rem;">
            <x-filament::icon icon="heroicon-o-clock" style="width: 1rem; height: 1rem;" />
            {{ $curso->duracion }}
        </span>
    </div>

    @if ($progreso)
        @include('filament.barra-progreso', ['porcentaje' => $progreso['porcentaje']])
    @endif
</div>

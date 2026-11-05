@php
    $modulos = $this->record->modulos()->with('lecciones')->get();
    $lecciones = $modulos->flatMap->lecciones->values();
    $i = $lecciones->search(fn ($l) => $l->id === $actual->id);
    $anterior = $i > 0 ? $lecciones[$i - 1] : null;
    $siguiente = $lecciones[$i + 1] ?? null;
    $youtube = $actual->youtubeId();
    $completadas = auth()->user()->estudiante->leccionesCompletadas()->pluck('lecciones.id');
    $progreso = $this->progreso();
    $hecha = $completadas->contains($actual->id);
@endphp

<x-filament-panels::page>
    {{-- Estilos de esta página (el CSS de Filament no trae clases de Tailwind sueltas) --}}
    <style>
        .hab-leccion { display: grid; gap: 1.5rem; grid-template-columns: minmax(0, 1fr); align-items: start; }
        @media (min-width: 1024px) { .hab-leccion { grid-template-columns: minmax(0, 1fr) 20rem; } }
        .hab-temario { position: sticky; top: 5rem; }
        .hab-video { position: relative; width: 100%; aspect-ratio: 16 / 9; background: #000; border-radius: 0.75rem; overflow: hidden; }
        .hab-video > * { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
        .hab-item { display: flex; align-items: center; gap: 0.5rem; padding: 0.45rem 0.6rem; border-radius: 0.5rem; font-size: 0.875rem; text-decoration: none; color: inherit; }
        .hab-item:hover { background: rgba(156, 163, 175, 0.15); }
        .hab-item.actual { background: rgba(219, 39, 119, 0.12); font-weight: 600; }
        .hab-acciones { display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    </style>

    <div class="hab-leccion"
         x-data
         x-on:leccion-completada.window="
            if (window.confetti) {
                const grande = $event.detail.cursoTerminado;
                confetti({ particleCount: grande ? 250 : 120, spread: grande ? 120 : 75, origin: { y: 0.6 } });
                if (grande) setTimeout(() => confetti({ particleCount: 150, spread: 160, origin: { y: 0.4 } }), 400);
            }
         ">

        {{-- Columna principal: video, completar y contenido --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem; min-width: 0;">
            <div class="hab-video">
                @if ($youtube)
                    <iframe src="https://www.youtube-nocookie.com/embed/{{ $youtube }}?rel=0"
                            title="{{ $actual->titulo }}"
                            allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                            allowfullscreen></iframe>
                @elseif ($actual->videoSrc())
                    <video controls preload="metadata" src="{{ $actual->videoSrc() }}">
                        Tu navegador no puede reproducir este video.
                    </video>
                @endif
            </div>

            <div class="hab-acciones">
                <div>
                    @if ($hecha)
                        <x-filament::badge color="success" icon="heroicon-s-check-circle" size="lg">Lección completada</x-filament::badge>
                    @else
                        {{ $this->completarAction }}
                    @endif
                </div>

                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    @if ($anterior)
                        <x-filament::button tag="a" :href="$this->urlLeccion($anterior)" color="gray" icon="heroicon-o-arrow-left">
                            Anterior
                        </x-filament::button>
                    @endif
                    @if ($siguiente)
                        <x-filament::button tag="a" :href="$this->urlLeccion($siguiente)" icon="heroicon-o-arrow-right" icon-position="after"
                                            :color="$hecha ? 'primary' : 'gray'">
                            Siguiente: {{ $siguiente->titulo }}
                        </x-filament::button>
                    @else
                        <x-filament::button tag="a" :href="\App\Filament\Estudiante\Resources\Cursos\CursoResource::getUrl('view', ['record' => $this->record])" color="gray">
                            Volver al curso
                        </x-filament::button>
                    @endif
                </div>
            </div>

            @if (filled($actual->contenido))
                <x-filament::section heading="Contenido de la lección">
                    <div class="fi-prose">
                        {!! str($actual->contenido)->sanitizeHtml() !!}
                    </div>
                </x-filament::section>
            @endif
        </div>

        {{-- Columna lateral: temario del curso --}}
        <aside class="hab-temario">
            <x-filament::section :heading="$this->record->nombre" icon="heroicon-o-list-bullet">
                <div style="margin-bottom: 1rem;">
                    @include('filament.barra-progreso', ['porcentaje' => $progreso['porcentaje']])
                    <p style="font-size: 0.8rem; opacity: 0.7;">{{ $progreso['completadas'] }} de {{ $progreso['total'] }} lecciones</p>
                </div>

                <nav aria-label="Temario del curso" style="display: flex; flex-direction: column; gap: 0.9rem;">
                    @foreach ($modulos as $modulo)
                        <div>
                            <p style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; opacity: 0.65; margin-bottom: 0.25rem;">
                                Módulo {{ $loop->iteration }} · {{ $modulo->titulo }}
                            </p>
                            @foreach ($modulo->lecciones as $leccion)
                                @php
                                    $esActual = $leccion->id === $actual->id;
                                    $completada = $completadas->contains($leccion->id);
                                @endphp
                                <a href="{{ $this->urlLeccion($leccion) }}" @class(['hab-item', 'actual' => $esActual])
                                   @if ($esActual) aria-current="page" @endif>
                                    <x-filament::icon
                                        :icon="$completada ? 'heroicon-s-check-circle' : ($esActual ? 'heroicon-s-play-circle' : 'heroicon-o-play-circle')"
                                        style="width: 1.15rem; height: 1.15rem; flex-shrink: 0; {{ $completada ? 'color: rgb(22 163 74);' : ($esActual ? 'color: rgb(219 39 119);' : 'opacity: .5;') }}" />
                                    <span>{{ $leccion->titulo }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </nav>
            </x-filament::section>
        </aside>
    </div>

    {{-- Confeti al completar (si no hay internet, simplemente no aparece) --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js" defer></script>
</x-filament-panels::page>

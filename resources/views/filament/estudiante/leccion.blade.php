@php
    $lecciones = $this->leccionesDelCurso();
    $i = $lecciones->search(fn ($l) => $l->id === $actual->id);
    $anterior = $i > 0 ? $lecciones[$i - 1] : null;
    $siguiente = $lecciones[$i + 1] ?? null;
    $youtube = $actual->youtubeId();
@endphp

<x-filament-panels::page>
    <x-filament::section>
        {{-- Video: YouTube embebido o reproductor nativo para mp4/webm --}}
        <div style="position: relative; width: 100%; aspect-ratio: 16 / 9; background: #000; border-radius: 0.5rem; overflow: hidden;">
            @if ($youtube)
                <iframe
                    src="https://www.youtube-nocookie.com/embed/{{ $youtube }}"
                    title="{{ $actual->titulo }}"
                    style="position: absolute; inset: 0; width: 100%; height: 100%; border: 0;"
                    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                    allowfullscreen
                ></iframe>
            @elseif ($actual->videoSrc())
                <video controls preload="metadata" src="{{ $actual->videoSrc() }}"
                    style="position: absolute; inset: 0; width: 100%; height: 100%;">
                    Tu navegador no puede reproducir este video.
                </video>
            @endif
        </div>
    </x-filament::section>

    @if (filled($actual->contenido))
        <x-filament::section heading="Contenido de la lección">
            <div class="fi-prose">
                {!! str($actual->contenido)->sanitizeHtml() !!}
            </div>
        </x-filament::section>
    @endif

    <div style="display: flex; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
        <div>
            @if ($anterior)
                <x-filament::button tag="a" :href="$this->urlLeccion($anterior)" color="gray" icon="heroicon-o-arrow-left">
                    {{ $anterior->titulo }}
                </x-filament::button>
            @endif
        </div>
        <div>
            @if ($siguiente)
                <x-filament::button tag="a" :href="$this->urlLeccion($siguiente)" icon="heroicon-o-arrow-right" icon-position="after">
                    {{ $siguiente->titulo }}
                </x-filament::button>
            @else
                <x-filament::button tag="a" :href="\App\Filament\Estudiante\Resources\Cursos\CursoResource::getUrl('view', ['record' => $this->record])" color="gray">
                    Volver al curso
                </x-filament::button>
            @endif
        </div>
    </div>
</x-filament-panels::page>

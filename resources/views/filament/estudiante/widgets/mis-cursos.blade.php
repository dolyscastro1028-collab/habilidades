<x-filament-widgets::widget>
    <x-filament::section heading="Mis cursos" icon="heroicon-o-academic-cap">
        @if ($cursos->isEmpty())
            <div style="text-align: center; padding: 1.5rem 0;">
                <p style="margin-bottom: 1rem;">Todavía no estás inscrito en ningún curso.</p>
                <x-filament::button tag="a" :href="$catalogo" icon="heroicon-o-magnifying-glass">
                    Ver catálogo de cursos
                </x-filament::button>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(16rem, 1fr)); gap: 1rem;">
                @foreach ($cursos as $item)
                    @php
                        $curso = $item['curso'];
                        $p = $item['progreso'];
                        $terminado = $p['total'] > 0 && $p['completadas'] === $p['total'];
                    @endphp
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(156, 163, 175, 0.35);">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: start; gap: 0.5rem;">
                                <h3 style="font-weight: 600; font-size: 1rem;">{{ $curso->nombre }}</h3>
                                @if ($terminado)
                                    <x-filament::badge color="success" icon="heroicon-s-trophy">¡Completado!</x-filament::badge>
                                @endif
                            </div>
                            <p style="font-size: 0.875rem; opacity: 0.75;">
                                {{ $curso->materia }} · {{ $curso->profesor?->nombre }}
                            </p>
                        </div>

                        @include('filament.barra-progreso', ['porcentaje' => $p['porcentaje']])

                        <p style="font-size: 0.875rem; opacity: 0.75;">
                            {{ $p['completadas'] }} de {{ $p['total'] }} lecciones
                            @if ($item['siguiente'])
                                · Siguiente: <strong>{{ $item['siguiente']->titulo }}</strong>
                            @endif
                        </p>

                        <div style="margin-top: auto;">
                            <x-filament::button tag="a" :href="$item['url']"
                                :color="$terminado ? 'gray' : 'primary'"
                                :icon="$terminado ? 'heroicon-o-arrow-path' : 'heroicon-o-play'">
                                {{ $terminado ? 'Repasar' : ($p['completadas'] ? 'Continuar' : 'Empezar') }}
                            </x-filament::button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>

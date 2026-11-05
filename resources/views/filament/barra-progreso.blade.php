{{--
    Barra de progreso. Sirve como:
      - columna de tabla / entrada de infolist (ViewColumn / ViewEntry): usa $getState()
      - include normal: @include('filament.barra-progreso', ['porcentaje' => 50])
    Estilos en línea: el CSS de Filament no incluye clases de Tailwind sueltas.
--}}
@php
    $p = $porcentaje ?? (isset($getState) ? $getState() : null);
@endphp

@if ($p === null)
    <span style="color: rgb(156 163 175);">—</span>
@else
    @php
        $color = match (true) {
            $p >= 100 => 'rgb(22 163 74)',   // verde
            $p > 0 => 'rgb(219 39 119)',     // rosado
            default => 'rgb(156 163 175)',   // gris
        };
    @endphp
    <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 9rem; padding: 0.25rem 0;"
         role="progressbar" aria-valuenow="{{ $p }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso: {{ $p }} %">
        <div style="flex: 1; height: 0.5rem; border-radius: 9999px; background: rgba(156, 163, 175, 0.3); overflow: hidden;">
            <div style="width: {{ $p }}%; height: 100%; border-radius: 9999px; background: {{ $color }}; transition: width .3s;"></div>
        </div>
        <span style="font-size: 0.875rem; font-weight: 600; font-variant-numeric: tabular-nums; min-width: 2.75rem; text-align: right;">{{ $p }} %</span>
    </div>
@endif

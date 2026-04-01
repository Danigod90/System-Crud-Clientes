<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $conNota->codigo_org }} — {{ $conNota->nombre_organizacion }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- ENCABEZADO --}}
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="font-mono text-blue-700 font-bold text-lg">{{ $conNota->codigo_org }}</span>
                        <p class="text-xs text-gray-500 mt-1">Registrado por {{ $conNota->registrado_por }} el {{ $conNota->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('secretaria.con-nota.edit', ['conNota' => $conNota->id]) }}"
                           style="background-color: #f59e0b; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none;">
                            Editar
                        </a>

                        @if($conNota->via_ingreso == 'presencial')
                        <a href="{{ route('secretaria.con-nota.nota-pdf', $conNota->id) }}" target="_blank"
                           style="background-color: #1e3a5f; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none;">
                            Imprimir Nota
                        </a>
                        @endif

                        @if($conNota->asunto_log && !$conNota->asunto_tec)
                        <a href="{{ route('secretaria.con-nota.recibo-logistica', $conNota->id) }}" target="_blank"
                           style="background-color: #065f46; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none;">
                            Imprimir Logistico
                        </a>
                        @endif

                        @if($conNota->asunto_log && !$conNota->asunto_tec && $conNota->log_estado !== 'entregada')
<form method="POST" action="{{ route('secretaria.con-nota.entregar-log', $conNota->id) }}" style="display:inline;">
    @csrf
    @method('PATCH')
    <button type="submit"
            onclick="return confirm('¿Confirmar entrega logística de {{ $conNota->nombre_organizacion }}?')"
            style="background-color: #065f46; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer; border: none;">
        Volver y terminar
    </button>
</form>
@else
<a href="{{ route('secretaria.con-nota.index') }}"
   style="background-color: #e5e7eb; color: #374151; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none;">
    Volver
</a>
@endif
                    </div>
                </div>{{-- fin encabezado --}}

                {{-- DATOS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Organizacion</p>
                        <p class="font-semibold text-gray-800">{{ $conNota->nombre_organizacion }}</p>
                        <p class="text-sm text-gray-500">{{ $conNota->tipo_organizacion }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Representante</p>
                        <p class="font-semibold text-gray-800">{{ $conNota->nombre_representante }}</p>
                        @if($conNota->telefono_representante)
                            <p class="text-sm text-gray-500">{{ $conNota->telefono_representante }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Asesor asignado</p>
                        <p class="font-semibold text-gray-800">{{ $conNota->asesor_asignado ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Via de ingreso</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $conNota->via_ingreso }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Fecha de eleccion</p>
                        <p class="font-semibold text-gray-800">
                            {{ $conNota->fecha_eleccion ? $conNota->fecha_eleccion->format('d/m/Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Asunto</p>
                        <p class="font-mono font-bold text-gray-800">{{ $conNota->asunto_texto }}</p>
                    </div>
                </div>{{-- fin datos --}}

                {{-- SERVICIOS SOLICITADOS --}}
                <div class="border-t pt-4">
                    <p class="text-xs text-gray-500 uppercase font-medium mb-3">Servicios solicitados</p>
                    <div class="flex gap-3 flex-wrap">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $conNota->asunto_char ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400 line-through' }}">
                            Char — Charla
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $conNota->asunto_log ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-400 line-through' }}">
                            Log — Logistica
                            @if($conNota->asunto_log && ($conNota->log_urnas || $conNota->log_cuartos || $conNota->log_tintas))
                                &nbsp;
                                @if($conNota->log_urnas) <span class="font-normal">({{ $conNota->log_urnas }}) urnas</span> @endif
                                @if($conNota->log_cuartos) <span class="font-normal">&nbsp;({{ $conNota->log_cuartos }}) cuartos</span> @endif
                                @if($conNota->log_tintas) <span class="font-normal">&nbsp;({{ $conNota->log_tintas }}) tintas</span> @endif
                            @endif
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $conNota->asunto_tec ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-400 line-through' }}">
                            Tec — Tecnica
                        </span>
                    </div>
                </div>{{-- fin servicios --}}

            </div>{{-- fin card --}}
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Entrada Con Nota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6 border-b pb-4">
                    <p class="text-gray-500 text-sm">N° de Entrada</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $conNota->numero_entrada }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Organización</p>
                        <p class="font-semibold">{{ $conNota->nombre_organizacion }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tipo de Organización</p>
                        <p class="font-semibold">{{ $conNota->tipo_organizacion }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Representante</p>
                        <p class="font-semibold">{{ $conNota->nombre_representante }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Asesor Asignado</p>
                        <p class="font-semibold">{{ $conNota->asesor_asignado ?? 'No asignado' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Vía de Ingreso</p>
                        <p class="font-semibold capitalize">{{ $conNota->via_ingreso }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Fecha de Registro</p>
                        <p class="font-semibold">{{ $conNota->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Registrado por</p>
                        <p class="font-semibold">{{ $conNota->user->name }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-gray-700 font-semibold mb-2">Servicios Solicitados</p>
                    @forelse($conNota->servicios as $servicio)
                        <div class="border rounded px-4 py-3 mb-2 bg-gray-50">
                            <p class="font-semibold capitalize">{{ str_replace('_', ' ', $servicio->tipo_servicio) }}</p>
                            @if($servicio->lugar_charla)
                                <p class="text-sm text-gray-600">Lugar: {{ $servicio->lugar_charla == 'fuera' ? 'Fuera de oficina' : 'En oficina' }}</p>
                            @endif
                            @if($servicio->direccion_charla)
                                <p class="text-sm text-gray-600">Dirección: {{ $servicio->direccion_charla }}</p>
                            @endif
                            @if($servicio->fecha_hora_charla)
                                <p class="text-sm text-gray-600">Fecha y hora: {{ $servicio->fecha_hora_charla->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">No hay servicios registrados.</p>
                    @endforelse
                </div>

                <a href="{{ route('secretaria.con-nota.index') }}"
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Volver al listado
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
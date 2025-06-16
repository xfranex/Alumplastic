<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="shadow rounded border border-gray-200">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h2 class="text-center font-semibold text-lg">Detalle de la Consulta de {{ $consulta->nombre }}</h2>
            </div>
            <div class="bg-white p-6 rounded-b space-y-6 text-gray-700">
                <div>
                    <h3 class="font-semibold text-gray-900">Nombre:</h3>
                    <p>{{ $consulta->nombre }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">Teléfono:</h3>
                    <p>{{ $consulta->telefono }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">Email:</h3>
                    <p>{{ $consulta->email }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">Mensaje:</h3>
                    <p class="whitespace-pre-line">{{ $consulta->mensaje }}</p>
                </div>

                <div class="text-center">
                    <a href="{{ route('consultas.index') }}"
                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                        ← Volver a Consultas
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

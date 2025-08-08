<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="shadow rounded border border-gray-200">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h2 class="text-center font-semibold text-lg">Cliente {{ $consulta->nombre }}</h2>
            </div>
            <div class="bg-white p-6 rounded-b space-y-6 text-gray-700 w-full">
                <div>
                    <h3 class="font-semibold text-gray-900">Nombre:</h3>
                    <p class="w-full">{{ $consulta->nombre }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Teléfono:</h3>
                    <p class="w-full">{{ $consulta->telefono }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Email:</h3>
                    <p class="w-full">{{ $consulta->email }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Mensaje:</h3>
                    <p class="break-words whitespace-pre-line w-full">{{ $consulta->mensaje }}</p>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-2">
                    <a href="{{ route('consultas.index') }}"
                        class="w-40 bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow text-center">
                        Volver
                    </a>
                    @can('delete', $consulta)
                        <form action="{{ route('consultas.destroy', $consulta) }}" method="POST" class="inline-block w-40">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow text-center botonEliminar">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

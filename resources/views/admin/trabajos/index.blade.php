<x-app-layout>
    <div class="px-4 py-2"></div>
    @can('create', \App\Models\Trabajo::class)
        <div class="flex justify-center mt-4 space-x-3">
            <a href="{{ route('trabajos.create') }}">
                <button class="bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded">
                    Crear Trabajo
                </button>
            </a>
        </div>
    @endcan

    @if (session('successTrabajoStore'))
        <div id="success-message"
            class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
            <p class="text-sm font-semibold">{{ session('successTrabajoStore') }}</p>
        </div>
    @elseif(session('successTrabajoUpdate'))
        <div id="success-message"
            class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
            <p class="text-sm font-semibold">{{ session('successTrabajoUpdate') }}</p>
        </div>
    @elseif(session('successTrabajoDelete'))
        <div id="success-message"
            class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
            <p class="text-sm font-semibold">{{ session('successTrabajoDelete') }}</p>
        </div>
    @endif

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Trabajos</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full max-w-3xl mx-auto border-collapse table-fixed hidden md:table">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">Carpintería</th>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">Imagen</th>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($trabajos as $trabajo)
                            <tr class="border-b border-gray-200">
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[20ch] break-words">
                                    {{ $trabajo->carpinteria->nombre }}
                                </td>
                                <td class="text-center py-3 px-4 whitespace-nowrap">
                                    <a href="{{ asset('storage/' . $trabajo->imagen) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">
                                        Ver Imagen
                                    </a>
                                </td>
                                @can('create', \App\Models\Trabajo::class)
                                    <td class="text-center py-3 px-4 whitespace-nowrap">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('trabajos.edit', $trabajo) }}">
                                                <button
                                                    class="min-w-[100px] bg-amber-400 hover:bg-amber-600 text-white font-semibold py-1 px-3 rounded whitespace-nowrap">
                                                    Editar
                                                </button>
                                            </a>
                                            <form action="{{ route('trabajos.destroy', $trabajo) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="min-w-[100px] bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded whitespace-nowrap botonEliminar">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4 p-4">
                @foreach ($trabajos as $trabajo)
                    <div class="border border-gray-200 rounded shadow p-4 bg-white">
                        <div class="mb-3">
                            <span class="font-semibold">Carpintería: </span>
                            <span class="break-words">{{ $trabajo->carpinteria->nombre }}</span>
                        </div>
                        <div class="mb-3 text-center">
                            <a href="{{ asset('storage/' . $trabajo->imagen) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">
                                Ver Imagen
                            </a>
                        </div>
                        @can('create', \App\Models\Trabajo::class)
                            <div class="flex flex-col space-y-2 items-center">
                                <a href="{{ route('trabajos.edit', $trabajo) }}">
                                    <button
                                        class="bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded min-w-[120px]">
                                        Editar
                                    </button>
                                </a>
                                <form action="{{ route('trabajos.destroy', $trabajo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded min-w-[120px] botonEliminar">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 3000);
        </script>
    </div>
</x-app-layout>

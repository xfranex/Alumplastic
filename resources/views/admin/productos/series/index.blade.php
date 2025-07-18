<x-app-layout>
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full flex justify-center my-4 space-x-2">
            <a href="{{ route('carpinterias.productos.index', $carpinteria) }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                    Volver a Productos de {{$carpinteria->nombre}}
                </button>
            </a>
        </div>

        @if (session('successSerieProductoStore'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successSerieProductoStore') }}</p>
            </div>
        @endif
        @if (session('successSerieProductoUpdate'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successSerieProductoUpdate') }}</p>
            </div>
        @endif
        @if (session('successSerieProductoDelete'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successSerieProductoDelete') }}</p>
            </div>
        @endif

        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t flex justify-center">
                <h3 class="font-semibold text-lg text-center">Información del Producto</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse table-fixed text-center">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-4 px-2 uppercase font-semibold text-sm">Nombre</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm">Carpintería</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr class="border-b border-gray-200">
                            <td class="py-4 px-2">{{ $producto->nombre }}</td>
                            <td class="py-4 px-2">{{ $carpinteria->nombre }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-center mt-10">
            <a href="">
                <button class="bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded">
                    Crear Serie
                </button>
            </a>
        </div>
        <div class="shadow rounded border border-gray-200 mt-4 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t flex justify-center">
                <h3 class="font-semibold text-lg text-center">Series Asociadas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-center">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/4">Nombre</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/3">Descripción</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/6">Imagen</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($series as $serie)
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-2">{{ $serie->nombre }}</td>
                                <td class="py-4 px-2">{{ Str::limit($serie->pivot->descripcion, 10) }}</td>
                                <td class="py-4 px-2">
                                    <a href="{{ asset('storage/' . $serie->pivot->imagen) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">
                                        Ver Imagen
                                    </a>
                                </td>
                                <td class="py-4 px-2">
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="" class="flex-1 min-w-[80px] max-w-[100px]">
                                            <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1.5 px-2 rounded text-xs sm:text-sm">
                                                Ver
                                            </button>
                                        </a>
                                        <a href="" class="flex-1 min-w-[80px] max-w-[100px]">
                                            <button class="w-full bg-amber-400 hover:bg-amber-600 text-white font-semibold py-1.5 px-2 rounded text-xs sm:text-sm">
                                                Editar
                                            </button>
                                        </a>
                                        <form action="" method="POST" class="flex-1 min-w-[80px] max-w-[100px] botonEliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-semibold py-1.5 px-2 rounded text-xs sm:text-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
</x-app-layout>

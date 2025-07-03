<x-app-layout>
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full flex justify-center my-4 space-x-2">
            <a href="{{ route('carpinterias.productos.create', $carpinteria) }}">
                <button class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                    Crear Producto
                </button>
            </a>
            <a href="{{ route('carpinterias.index') }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                    Carpinterías
                </button>
            </a>
        </div>

        @if (session('successProductoStore'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successProductoStore') }}</p>
            </div>
        @elseif(session('successProductoUpdate'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successProductoUpdate') }}</p>
            </div>
        @elseif(session('successProductoDelete'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successProductoDelete') }}</p>
            </div>
        @endif

        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t flex justify-center">
                <h3 class="font-semibold text-lg text-center">Productos de {{ $carpinteria->nombre }}</h3>
            </div>

            <div class="overflow-x-auto lg:overflow-x-visible hidden md:block">
                <table class="w-full border-collapse table-fixed text-center">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/4 align-middle">Nombre</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/2 align-middle">Series</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/4 align-middle">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($productos as $producto)
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-2 truncate align-middle">
                                    {{ $producto->nombre }}
                                </td>
                                <td class="py-4 px-2 align-middle">
                                    <a href="{{ route('productos.series.index', $producto) }}"
                                        class="text-blue-600 hover:underline font-semibold">
                                        Ver Series
                                    </a>
                                </td>
                                <td class="py-4 px-2 align-middle">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('productos.edit', $producto) }}" class="flex-1 min-w-[120px]">
                                            <button
                                                class="w-full bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 rounded">
                                                Editar
                                            </button>
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                            class="flex-1 min-w-[120px]">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-red-500 hover:bg-red-700 text-white font-semibold py-2 rounded botonEliminar">
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

            <div class="md:hidden space-y-4 p-4">
                @foreach ($productos as $producto)
                    <div class="border border-gray-200 rounded shadow p-4 bg-white">
                        <div class="mb-2">
                            <span class="font-semibold">Producto: </span>
                            <span class="break-words">{{ $producto->nombre }}</span>
                        </div>
                        <div class="mb-4 text-center">
                            <a href="{{ route('productos.series.index', $producto) }}"
                                class="text-blue-600 hover:underline font-semibold">
                                Ver Series
                            </a>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('productos.edit', $producto) }}" class="col-span-2">
                                <button
                                    class="w-full bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 rounded">
                                    Editar
                                </button>
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                class="col-span-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-500 hover:bg-red-700 text-white font-semibold py-2 rounded botonEliminar">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
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

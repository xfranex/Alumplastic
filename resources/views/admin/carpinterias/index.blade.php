<x-app-layout>
    <div class="px-4 py-2"></div>
    <div class="flex justify-center mt-4 space-x-3">
        <a href="{{ route('carpinterias.create') }}">
            <button class="bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded">
                Crear Carpintería
            </button>
        </a>
        <a href="{{ route('carpinterias.create') }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Series
            </button>
        </a>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Carpinterías</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full max-w-2xl mx-auto border-collapse table-fixed hidden md:table">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/2 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">
                                Nombre
                            </th>
                            <th class="w-1/2 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($carpinterias as $carpinteria)
                            <tr class="border-b border-gray-200">
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[20ch] break-words">
                                    {{ $carpinteria->nombre }}
                                </td>
                                <td class="text-center py-3 px-4 whitespace-nowrap">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('carpinterias.edit', $carpinteria) }}">
                                            <button
                                                class="min-w-[100px] bg-amber-400 hover:bg-amber-600 text-white font-semibold py-1 px-3 rounded whitespace-nowrap">
                                                Editar
                                            </button>
                                        </a>
                                        <a href="{{ route('carpinterias.productos.index', $carpinteria) }}"> <!--hacer ruta anidada-->
                                            <button
                                                class="min-w-[100px] bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded whitespace-nowrap">
                                                Productos
                                            </button>
                                        </a>
                                        <form action="{{ route('carpinterias.destroy', $carpinteria) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="min-w-[100px] bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded whitespace-nowrap">
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
                @foreach ($carpinterias as $carpinteria)
                    <div class="border border-gray-200 rounded shadow p-4 bg-white">
                        <div class="mb-3">
                            <span class="font-semibold">Nombre: </span>
                            <span class="break-words">{{ $carpinteria->nombre }}</span>
                        </div>
                        <div class="flex flex-col space-y-2 items-center">
                            <a href="{{ route('carpinterias.edit', $carpinteria) }}">
                                <button
                                    class="bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded min-w-[120px]">
                                    Editar
                                </button>
                            </a>
                            <a href="{{ route('carpinterias.productos.index', $carpinteria) }}"> <!--hacer ruta anidada-->
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded min-w-[120px]">
                                    Productos
                                </button>
                            </a>
                            <form action="{{ route('carpinterias.destroy', $carpinteria) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded min-w-[120px]">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
       

        @if (session('successCarpinteriaStore'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successCarpinteriaStore') }}</p>
            </div>
        @elseif(session('successCarpinteriaUpdate'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successCarpinteriaUpdate') }}</p>
            </div>
        @elseif(session('successCarpinteriaDelete'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successCarpinteriaDelete') }}</p>
            </div>
        @endif

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

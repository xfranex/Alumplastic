<x-app-layout>
    <div class="px-4 py-2"></div>
    @if (session('successEliminadoConsulta'))
        <div id="success-message-producto"
            class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
            <p class="text-sm font-semibold">{{ session('successEliminadoConsulta') }}</p>
        </div>
    @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Consultas Recibidas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border-collapse table-fixed hidden md:table">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/6 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">
                                Nombre
                            </th>
                            <th class="w-1/6 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">
                                Teléfono</th>
                            <th class="w-1/6 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">
                                Email
                            </th>
                            <th
                                class="w-2/6 text-center py-3 px-4 uppercase font-semibold text-sm truncate max-w-[15ch]">
                                Mensaje</th>
                            <th class="w-1/6 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($consultas as $consulta)
                            <tr class="border-b border-gray-200">
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[12ch]">
                                    {{ $consulta->nombre }}</td>
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[12ch]">
                                    {{ $consulta->telefono }}</td>
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[20ch]">
                                    {{ $consulta->email }}</td>
                                <td class="text-center py-3 px-4 truncate max-w-[15ch]">
                                    {{ Str::limit($consulta->mensaje, 10) }}
                                </td>
                                <td class="text-center py-3 px-4 whitespace-nowrap">
                                    <div class="inline-flex space-x-2 justify-center">
                                        <a href="{{ route('consultas.show', $consulta) }}">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded">
                                                Ver
                                            </button>
                                        </a>
                                        @can('delete', $consulta)
                                            <form action="{{ route('consultas.destroy', $consulta) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded botonEliminar">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="md:hidden space-y-4 bg-white p-4">
                @foreach ($consultas as $consulta)
                    <div class="border border-gray-200 rounded shadow p-4">
                        <div><span class="font-semibold">Nombre: </span>{{ $consulta->nombre }}</div>
                        <div><span class="font-semibold">Teléfono: </span>{{ $consulta->telefono }}</div>
                        <div><span class="font-semibold">Email: </span>{{ $consulta->email }}</div>
                        <div><span class="font-semibold">Mensaje: </span>
                            <p class="break-words">{{ $consulta->mensaje }}</p>
                        </div>
                        <div class="mt-3 flex space-x-2 justify-center">
                            <a href="{{ route('consultas.show', $consulta) }}">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded w-full">
                                    Ver
                                </button>
                            </a>
                            @can('delete', $consulta)
                                <form action="{{ route('consultas.destroy', $consulta) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded w-full botonEliminar">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('success-message-producto');
            if (msg) {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }
        }, 3000);
    </script>
</x-app-layout>

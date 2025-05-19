<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
        <span class="text-sm text-gray-600">Bienvenido, {{ Auth::user()->name }}</span>
    </x-slot>
    <div class="flex flex-col lg:flex-row gap-4 px-4 pb-4 pt-6">
        <div class="w-full lg:w-1/2">
            <div class="shadow overflow-x-auto rounded border border-gray-200">
                <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                    <h3 class="text-center font-semibold text-lg">Tipo de Productos</h3>
                </div>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/2 text-center py-3 px-4 uppercase font-semibold text-sm">Nombre</th>
                            <th class="w-1/2 text-center py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($tiposProductos as $tipoProducto)
                            <tr>
                                <td class="text-center py-3 px-4">{{ $tipoProducto->nombre_tipo_producto }}</td>
                                <td class="text-center py-3 px-4">
                                    <div class="inline-flex space-x-2 justify-center">
                                        <a href="{{ route('tipos.edit', $tipoProducto) }}">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded">Editar
                                            </button>
                                        </a>
                                        <form action="{{ route('tipos.destroy', $tipoProducto) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded">Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bg-white px-4 py-4 flex justify-center rounded-b">
                    <a href="{{ route('tipos.create') }}"
                        class="bg-gray-800 text-white hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow-sm text-sm sm:text-base">
                        Crear tipo de producto
                    </a>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2">
            <div class="shadow overflow-x-auto rounded border border-gray-200">
                <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                    <h3 class="text-center font-semibold text-lg">Productos</h3>
                </div>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm">Nombre</th>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm">Tipo</th>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($productos as $producto)
                            <tr>
                                <td class="text-center py-3 px-4">{{ $producto->nombre }}</td>
                                <td class="text-center py-3 px-4">{{ $producto->tipoProducto->nombre_tipo_producto }}
                                </td>
                                <td class="text-center py-3 px-4">
                                    <div class="inline-flex space-x-2 justify-center">
                                        <a href="{{ route('productos.edit', $producto) }}">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded">Editar</button>
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bg-white px-4 py-4 flex justify-center rounded-b">
                    <a href="{{ route('productos.create') }}"
                        class="bg-gray-800 text-white hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow-sm text-sm sm:text-base">
                        Crear producto
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 pb-8">
        @if (session('successT'))
            <div id="success-message-tipo"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successT') }}</p>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('success-message-tipo');
                    if (msg) {
                        msg.style.transition = 'opacity 0.5s ease';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 4000);
            </script>
        @endif
        @if (session('success'))
            <div id="success-message-producto"
                class="max-w-md mx-auto mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('success-message-producto');
                    if (msg) {
                        msg.style.transition = 'opacity 0.5s ease';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 4000);
            </script>
        @endif
    </div>
</x-app-layout>

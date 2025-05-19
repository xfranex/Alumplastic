<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Producto
        </h2>
    </x-slot>
    <div class="md:px-32 py-8 w-full max-w-4xl mx-auto">
        <div class="shadow overflow-hidden rounded border border-gray-200">
            <div class="bg-gray-800 text-white py-3 px-6 rounded-t">
                <h3 class="text-center font-semibold text-lg">Crear Nuevo Producto</h3>
            </div>
            <div class="bg-white p-6">
                <form action="{{ route('productos.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 font-semibold mb-2">
                            Nombre del Producto
                        </label>
                        <input type="text" name="nombre" id="nombre"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300"
                            value="{{ old('nombre') }}" placeholder="Ingrese el nombre del producto">
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="tipo_producto_id" class="block text-gray-700 font-semibold mb-2">
                            Tipo de Producto
                        </label>
                        <select name="tipo_producto_id" id="tipo_producto_id"
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">Seleccione un tipo</option>
                            @foreach ($tiposProductos as $tipo)
                                <option value="{{ $tipo->id }}"
                                    {{ old('tipo_producto_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre_tipo_producto }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_producto_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('productos.index') }}"
                            class="bg-gray-200 text-gray-800 hover:bg-gray-300 font-semibold py-2 px-4 rounded shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-gray-800 text-white hover:bg-gray-700 font-semibold py-2 px-4 rounded shadow-sm">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

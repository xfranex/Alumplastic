<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear Tipo de Producto
      </h2>
    </x-slot>
    <div class="md:px-32 py-8 w-full max-w-4xl mx-auto">
      <div class="shadow overflow-hidden rounded border border-gray-200">
        <div class="bg-gray-800 text-white py-3 px-6 rounded-t">
          <h3 class="text-center font-semibold text-lg">Crear Nuevo Tipo de Producto</h3>
        </div>
        <div class="bg-white p-6">
          <form action="{{ route('tipos.store') }}" method="POST">
            @csrf
            <div class="mb-4">
              <label for="nombre_tipo_producto" class="block text-gray-700 font-semibold mb-2">
                Nombre del Tipo de Producto
              </label>
              <input
                type="text"
                name="nombre_tipo_producto"
                id="nombre_tipo_producto"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300"
                value="{{ old('nombre_tipo_producto') }}"
                placeholder="Ingrese el nombre del tipo de producto">
                @error('nombre_tipo_producto')
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

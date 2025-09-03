<x-app-layout>
    <div class="px-4 py-2"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Editar Producto {{$producto->nombre}}-{{$carpinteria->nombre}}</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('productos.update', $producto) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="carpinteria_id" class="block text-gray-700 font-semibold mb-2">Carpintería</label>
                        <select name="carpinteria_id" id="carpinteria_id" 
                            class="w-full border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione una carpintería</option>
                            @foreach ($carpinterias as $carpinteriaU)
                                <option value="{{ $carpinteriaU->id }}" {{ old('carpinteria_id', $carpinteria->id ?? '') == $carpinteriaU->id ? 'selected' : '' }}>
                                    {{ $carpinteriaU->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('carpinteria_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre del Producto</label>
                        <input type="text" name="nombre" id="nombre"
                            value="{{ old('nombre', $producto->nombre) }}"
                            class="w-full border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingresa el nombre">
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col sm:flex-row justify-center sm:space-x-4 space-y-4 sm:space-y-0">
                        <button type="submit"
                            class="w-full sm:w-auto bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded whitespace-nowrap">
                            Actualizar
                        </button>
                        <a href="{{ route('carpinterias.productos.index', $carpinteria) }}" class="w-full sm:w-auto">
                            <button type="button"
                                class="w-full sm:w-auto bg-gray-500 hover:bg-gray-800 text-white font-semibold py-2 px-6 rounded whitespace-nowrap">
                                Cancelar
                            </button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
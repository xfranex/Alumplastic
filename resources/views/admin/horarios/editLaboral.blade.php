<x-app-layout>
    <div class="px-4 py-2"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Editar {{ ucfirst($horario->tipo) }}</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('horarios.update', $horario) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-2 text-gray-700 font-semibold">Selecciona los días operativos:</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($semana as $dia)
                                <label class="inline-flex items-center min-w-[90px]">
                                    <input type="checkbox" name="dias[]" value="{{ $dia['nombre'] }}" class="form-checkbox h-5 w-5 focus:ring-2 focus:ring-blue-500"
                                         {{ (is_array(old('dias')) && in_array($dia['nombre'], old('dias'))) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 whitespace-nowrap">{{ $dia['clave'] }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('dias')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 font-semibold">Mañana:</label>
                        <div class="flex items-center space-x-2">
                            <input type="time" name="mañana_inicio"
                                value="{{ old('mañana_inicio') }}"
                                class="w-32 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700 font-semibold">-</span>
                            <input type="time" name="mañana_fin"
                                value="{{ old('mañana_fin') }}"
                                class="w-32 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('mañana_inicio')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                        @error('mañana_fin')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 font-semibold">Tarde:</label>
                        <div class="flex items-center space-x-2">
                            <input type="time" name="tarde_inicio"
                                value="{{ old('tarde_inicio') }}"
                                class="w-32 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700 font-semibold">-</span>
                            <input type="time" name="tarde_fin"
                                value="{{ old('tarde_fin') }}"
                                class="w-32 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('tarde_inicio')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                        @error('tarde_fin')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center sm:space-x-4 space-y-4 sm:space-y-0">
                        <button type="submit"
                            class="w-full sm:w-auto bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded whitespace-nowrap">
                            Actualizar
                        </button>
                        <a href="{{ route('horarios.index') }}" class="w-full sm:w-auto">
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

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
                        <label class="block mb-2 text-gray-700 font-semibold">Estamos de vacaciones del:</label>                    
                            <input type="number" name="dia_inicio" value="{{ old('dia_inicio') }}"
                                class="w-16 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Día"/>

                            <select name="mes_inicio" class="border-gray-300 w-32 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled selected>Mes</option>
                                @foreach ($meses as $mes)
                                    <option value="{{ $mes }}" {{ old('mes_inicio') == $mes ? 'selected' : '' }}>{{ $mes }}</option>
                                @endforeach
                            </select>

                            <span> al </span>

                            <input type="number" name="dia_fin" value="{{ old('dia_fin') }}"
                                class="w-16 border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Día"/>

                            <select name="mes_fin" class="border-gray-300 w-32 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled selected>Mes</option>
                                @foreach ($meses as $mes)
                                    <option value="{{ $mes }}" {{ old('mes_fin') == $mes ? 'selected' : '' }}>{{ $mes }}</option>
                                @endforeach
                            </select>

                        @error('dia_inicio')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                        @error('mes_inicio')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                        @error('dia_fin')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                        @error('mes_fin')
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

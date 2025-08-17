<x-app-layout>
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
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
        @elseif(session('successHorarioDelete'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successHorarioDelete') }}</p>
            </div>
        @elseif(session('successSerieProductoDelete'))
            <div id="success-message"
                class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
                <p class="text-sm font-semibold">{{ session('successSerieProductoDelete') }}</p>
            </div>
        @endif

        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t flex justify-center">
                <h3 class="font-semibold text-lg text-center">{{ ucfirst($laboral->tipo) }}</h3>
            </div>

            <div class="overflow-x-auto lg:overflow-x-visible hidden md:block">
                <table class="w-full border-collapse table-fixed text-center">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/4 align-middle">Apertura</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/2 align-middle">Días</th>
                            <th class="py-4 px-2 uppercase font-semibold text-sm w-1/4 align-middle">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-2 truncate align-middle">
                                    {{ $laboral->hora_mañana }} <br> {{ $laboral->hora_tarde }}    
                                </td>
                                <td class="py-4 px-2 align-middle">
                                    {{ $laboral->mensaje_laboral }}
                                </td>
                                <td class="py-4 px-2 align-middle">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                            <a href="" class="flex-1 min-w-[120px]">
                                                <button
                                                    class="w-full bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 rounded">
                                                    Establecer
                                                </button>
                                            </a>
                                            <form action="{{ route('horarios.destroy', $laboral) }}" method="POST"
                                                class="flex-1 min-w-[120px]">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full {{ $laboral->activo ? 'bg-green-600' : 'bg-gray-600' }} text-white font-semibold py-2 rounded">
                                                    {{ $laboral->activo ? "Activado" : "Desactivado"}}
                                                </button>
                                            </form>
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4 p-4">
                    <div class="border border-gray-200 rounded shadow p-4 bg-white">
                        <div class="mb-4 text-center">
                            {{ $laboral->mensaje_laboral }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">Apertura: </span>
                            <span class="break-words">{{ $laboral->hora_mañana }} {{ $laboral->hora_tarde }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                                <a href="" class="col-span-2">
                                    <button
                                        class="w-full bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 rounded">
                                        Establecer
                                    </button>
                                </a>
                                <form action="{{ route('horarios.destroy', $laboral) }}" method="POST"
                                    class="col-span-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full {{ $laboral->activo ? 'bg-green-600' : 'bg-gray-600' }}  text-white font-semibold py-2 rounded">
                                        {{ $laboral->activo ? "Activado" : "Desactivado"}}
                                    </button>
                                </form>
                        </div>
                    </div>
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
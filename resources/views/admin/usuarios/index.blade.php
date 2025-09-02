<x-app-layout>
    <div class="px-4 py-2"></div>

    @if (session('successUsuarioUpdate'))
        <div id="success-message"
            class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
            <p class="text-sm font-semibold">{{ session('successUsuarioUpdate') }}</p>
        </div>
    @endif
    @if (session('successUsuarioDelete'))
        <div id="success-message"
            class="max-w-md mx-auto mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md text-center">
            <p class="text-sm font-semibold">{{ session('successUsuarioDelete') }}</p>
        </div>
    @endif

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Usuarios</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full max-w-3xl mx-auto border-collapse table-fixed hidden md:table">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">Email</th>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">Rol</th>
                            <th class="w-1/3 text-center py-3 px-4 uppercase font-semibold text-sm whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($usuarios as $usuario)
                            <tr class="border-b border-gray-200">
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[20ch] break-words">
                                    {{ $usuario->email }}
                                </td>
                                <td class="text-center py-3 px-4 whitespace-nowrap truncate max-w-[20ch] break-words">
                                    @if ($usuario->rol_id === null)
                                        <span class="text-red-500 font-bold">Desactivado</span>
                                    @else
                                        {{ $usuario->rol->nombre_rol }}
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 whitespace-nowrap">
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('usuarios.edit', $usuario) }}">
                                            <button
                                                class="w-full sm:w-[200px] h-[40px] bg-amber-400 hover:bg-amber-600 text-white font-semibold py-1 px-3 rounded whitespace-nowrap">
                                                Cambiar contraseña
                                            </button>
                                        </a>
                                        @if ($usuario->id === 2)
                                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="w-full sm:w-[200px]">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full h-[40px] {{ $usuario->rol_id ? 'bg-green-600' : 'bg-gray-600' }} text-white font-semibold py-2 rounded">
                                                    {{ $usuario->rol_id ? 'Activado' : 'Desactivado' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4 p-4">
                @foreach ($usuarios as $usuario)
                    <div class="border border-gray-200 rounded shadow p-4 bg-white">
                        <div class="mb-3">
                            <span class="font-semibold">Email: </span>
                            <span class="break-words">{{ $usuario->email }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="font-semibold">Rol: </span>
                            @if ($usuario->rol_id === null)
                                <span class="break-words text-red-500 font-bold">Desactivado</span>
                            @else
                                <span class="break-words">{{ $usuario->rol->nombre_rol }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col items-center space-y-2">
                            <a href="{{ route('usuarios.edit', $usuario) }}">
                                <button
                                    class="w-[200px] h-[40px] bg-amber-400 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded">
                                    Cambiar contraseña
                                </button>
                            </a>
                            @if ($usuario->id === 2)
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="w-[200px]">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="h-[40px] {{ $usuario->rol_id ? 'bg-green-600' : 'bg-gray-600' }} text-white font-semibold py-2 rounded w-[200px]">
                                        {{ $usuario->rol_id ? 'Activado' : 'Desactivado' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
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
    </div>
</x-app-layout>

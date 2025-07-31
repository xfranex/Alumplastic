<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="w-full flex flex-col md:flex-row items-center justify-center my-4 space-y-2 md:space-y-0 md:space-x-2">
            <a href="{{ route('productos.series.index', $producto) }}" class="w-48">
                <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Volver a Series de {{ $producto->nombre }}
                </button>
            </a>
            @can('delete', \App\Models\Producto::class)
                <form action="{{ route('productos.series.destroy', ['producto' => $producto, 'serie' => $serie]) }}" method="POST" class="inline-block w-48">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow text-center botonEliminar">
                            Eliminar
                    </button>
                </form>
            @endcan
        </div>

        <div class="shadow rounded border border-gray-200 bg-white">
            <div class="bg-gray-800 text-white py-4 px-6 rounded-t">
                <h1 class="text-lg font-semibold text-center">
                    Información de la Serie
                </h1>
            </div>
            <div class="p-6 space-y-2 text-gray-700">
                <div class="grid sm:grid-cols-3 gap-4 text-center">
                    <div class="rounded p-4">
                        <p class="uppercase font-semibold text-sm">Producto</p>
                        <p class="mt-1 text-base">{{ $producto->nombre }}</p>
                    </div>
                    <div class="rounded p-4">
                        <p class="uppercase font-semibold text-sm">Serie</p>
                        <p class="mt-1 text-base">{{ $serie->nombre }}</p>
                    </div>
                    <div class="rounded p-4">
                        <p class="uppercase font-semibold text-sm">Carpintería</p>
                        <p class="mt-1 text-base">{{ $carpinteria->nombre }}</p>
                    </div>
                </div>
                <div class="w-full flex justify-center rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $serie->pivot->imagen) }}" class="w-full max-w-4xl aspect-[16/9] object-cover"/>
                </div>
                <div class="flex justify-center">
                    <p class="text-gray-700 whitespace-pre-line text-justify text-base leading-relaxed max-w-4xl px-2">
                        {{ $serie->pivot->descripcion }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

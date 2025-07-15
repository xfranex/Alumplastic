<x-app-layout>
    <div class="px-4 py-2"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Crear Trabajo</h3>
            </div>
            <div class="p-6">
                <form id="form-trabajo" method="POST" action="{{ route('trabajos.store') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="carpinteria_id" class="block text-gray-700 font-semibold mb-2">Carpintería</label>
                        <select name="carpinteria_id" id="carpinteria_id" 
                            class="w-full border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione una carpintería</option>
                            @foreach ($carpinterias as $carpinteria)
                                <option value="{{ $carpinteria->id }}" {{ old('carpinteria_id') == $carpinteria->id ? 'selected' : '' }}>
                                    {{ $carpinteria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('carpinteria_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="inputImagen" class="block text-gray-700 font-semibold mb-2">Imagen</label>
                        <input type="file" id="inputImagen" accept="image/*" name="imagen" 
                            class="border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('imagen')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-center">
                        <div class="relative w-full max-w-lg aspect-[4/3] bg-gray-100">
                            <img id="image" class="absolute inset-0 w-full h-full object-cover"/>
                        </div>
                    </div>
                    <div class="my-2 flex flex-col space-y-2 sm:flex-row sm:space-x-2 sm:space-y-0 justify-center">
                        <button type="button" id="rotateLeft"
                            class="bg-gray-500 hover:bg-gray-800 text-white font-semibold py-1 px-3 rounded">
                            Rotar Izquierda
                        </button>
                        <button type="button" id="rotateRight"
                            class="bg-gray-500 hover:bg-gray-800 text-white font-semibold py-1 px-3 rounded">
                            Rotar Derecha
                        </button>
                    </div>
                    <input type="hidden" name="cropped_image" id="croppedImageInput" />
                    <div class="flex flex-col sm:flex-row justify-center sm:space-x-4 space-y-4 sm:space-y-0">
                        <button type="submit"
                            class="w-full sm:w-auto bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded whitespace-nowrap">
                            Guardar
                        </button>
                        <a href="{{ route('trabajos.index') }}" class="w-full sm:w-auto">
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

    <script>
        let cropper;
        const image = document.getElementById('image');
        const inputImagen = document.getElementById('inputImagen');
        const croppedImageInput = document.getElementById('croppedImageInput');

        inputImagen.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const url = URL.createObjectURL(file);

                image.src = url;
                image.style.display = 'block';

                if (cropper) cropper.destroy();

                cropper = new Cropper(image, {
                    aspectRatio: 600 / 400,
                    viewMode: 1,
                    autoCropArea: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: true,
                    scalable: false,
                    background: false,
                    /*minCropBoxWidth: 600,
                    minCropBoxHeight: 400,
                    minContainerWidth: 600,
                    minContainerHeight: 400,*/
                    responsive: true,
                    cropBoxResizable: false 
                });
            }
        });

        document.getElementById('rotateLeft').addEventListener('click', () => {
            if (cropper) cropper.rotate(-90);
        });

        document.getElementById('rotateRight').addEventListener('click', () => {
            if (cropper) cropper.rotate(90);
        });

        document.getElementById('form-trabajo').addEventListener('submit', function(e) {
            e.preventDefault();

            if (cropper) {
                cropper.getCroppedCanvas({
                    width: 600,
                    height: 400,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                }).toBlob((blob) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(blob); // Convertir a base64
                    reader.onloadend = function() {
                        croppedImageInput.value = reader.result;
                        e.target.submit();
                    };
                }, 'image/webp', 1);
            } else {
                e.target.submit();
            }
        });
    </script>
</x-app-layout>

<x-app-layout>
    <div class="px-4 py-2"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shadow rounded border border-gray-200 mt-6 bg-white">
            <div class="bg-gray-800 text-white py-3 px-4 rounded-t">
                <h3 class="text-center font-semibold text-lg">Editar Trabajo</h3>
            </div>
            <div class="p-6">
                <form id="form-trabajo" method="POST" action="{{ route('trabajos.update', $trabajo) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="carpinteria_id" class="block text-gray-700 font-semibold mb-2">Carpintería</label>
                        <select name="carpinteria_id" id="carpinteria_id"
                            class="w-full border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione una carpintería</option>
                            @foreach ($carpinterias as $carpinteria)
                                <option value="{{ $carpinteria->id }}"
                                    {{ $trabajo->carpinteria_id == $carpinteria->id ? 'selected' : '' }}>
                                    {{ $carpinteria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('carpinteria_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="imagenSubir" class="block text-gray-700 font-semibold mb-2">Nueva Imagen</label>
                        <input type="file" id="imagenSubir" accept="image/*"
                            class="border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('cropped_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-center">
                        <div class="relative w-full max-w-lg aspect-[3/2] bg-gray-100">
                            <img id="image" class="absolute inset-0 w-full h-full object-cover"
                                src="{{ asset('storage/' . $trabajo->imagen) }}" />
                        </div>
                    </div>
                    <div class="my-2 space-x-2 flex justify-center">
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
                            Actualizar
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        let cropper;
        const image = document.getElementById('image');
        const imagenSubir = document.getElementById('imagenSubir');
        const croppedImageInput = document.getElementById('croppedImageInput');

        imagenSubir.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const url = URL.createObjectURL(file);

                image.src = url;

                image.onload = function() {
                    if (cropper) cropper.destroy();

                    cropper = new Cropper(image, {
                        aspectRatio: 600 / 400,
                        viewMode: 3,
                        autoCropArea: 1,
                        movable: true,
                        zoomable: false,
                        rotatable: true, 
                        scalable: false,
                        cropBoxResizable: false,
                        dragMode: 'move',
                        background: false,
                        responsive: true,

                        ready() {
                            const containerData = cropper.getContainerData();
                            cropper.setCropBoxData({
                                width: 600,
                                height: 400,
                                left: (containerData.width - 600) / 2,
                                top: (containerData.height - 400) / 2
                            });
                        }
                    });
                }
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

            cropper.getCroppedCanvas({
                width: 600,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            }).toBlob((blob) => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    croppedImageInput.value = reader.result;
                    e.target.submit();
                }
            }, 'image/jpeg', 1);
        });
    </script>
</x-app-layout>

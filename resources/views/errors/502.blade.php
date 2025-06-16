@vite('resources/css/app.css')
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 p-6 text-center">
    <div class="bg-white shadow-2xl rounded-2xl p-10 max-w-lg w-full sm:w-3/4 md:w-1/2 lg:w-1/3 border-t-8 border-red-600">
        <h1 class="text-xl font-semibold text-red-600">502</h1>
        <h2 class="text-3xl font-semibold text-blue-700 mb-3">Ups, algo salió mal</h2>
        <p class="text-gray-700 mb-3">
            Lo sentimos, ocurrió un error
        </p>
        <p class="text-xl font-semibold text-red-600">
            En 10 segundos será redirigido al inicio
        </p>
    </div>
</div>
<script>
    setTimeout(() => {
        window.location.href = "{{ route('welcome') }}";
    }, 10000);
</script>
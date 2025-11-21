import './bootstrap';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start(); //inicializa Alpine incluido con Laravel Breeze

document.addEventListener('DOMContentLoaded', () => { //cuando el DOM ha sido completamente cargado coge los elementos que tenga la clase .botonEliminar y cuando son pulsados sale un cuadrado para completar la acción (al eliminar un recurso sale)
    const botones = document.querySelectorAll('.botonEliminar');

    botones.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const form = boton.closest('form');

            Swal.fire({ //librería JS para mostrar alertas bonitas
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b91c1c',
                cancelButtonColor: '#2563eb',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
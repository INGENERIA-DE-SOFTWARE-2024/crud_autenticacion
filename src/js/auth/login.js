const { validarFormulario, Toast } = require("../funciones");

const formulario = document.querySelector('form');

const iniciar = async (e) => {
    e.preventDefault();
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            title: 'Debe llenar todos los campos'
        });
        return;
    }

    try {
        const body = new FormData(formulario);
        const url = "/crud_autenticacion/API/login";
        const config = {
            method: 'POST',
            body
        };

        const respuesta = await fetch(url, config);

        if (!respuesta.ok) {
            throw new Error(`HTTP error! Status: ${respuesta.status}`);
        }

        const data = await respuesta.json();
        const { codigo, mensaje, detalle } = data;

        console.log(data);

        let icon = 'info';
        if (codigo === 1) {
            icon = 'success';
            formulario.reset();
            location.href = '/crud_autenticacion/menu'; // Redirige al usuario
        } else {
            icon = 'error';
            console.log(detalle);
        }

        Toast.fire({
            icon: icon,
            title: mensaje
        });
    } catch (error) {
        console.error('Error:', error);
    }
};

formulario.addEventListener('submit', iniciar);

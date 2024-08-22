import { Dropdown  } from 'bootstrap';
import { Toast, validarFormulario } from "../funciones";
import Swal from "sweetalert2";

const formulario = document.getElementById('formPermiso');
const tabla = document.getElementById('tablaPermiso');
const btnGuardar = document.getElementById('btnGuardar')
const btnModificar = document.getElementById('btnModificar')
const btnCancelar = document.getElementById('btnCancelar')

btnModificar.parentElement.style.display = 'none'
btnModificar.disabled = true
btnCancelar.parentElement.style.display = 'none'
btnCancelar.disabled = true

const Buscar = async () => {
    try {
        const url = '/crud_autenticacion/API/permiso/buscar';
        const respuesta = await fetch(url);
        const data = await respuesta.json();

        tabla.tBodies[0].innerHTML = '';
        const fragment = document.createDocumentFragment();
        let contador = 1;

        if (data.length > 0) {
            tabla.parentElement.parentElement.classList.remove('d-none');
            data.forEach(permiso => {
                const tr = document.createElement('tr');
                const celda1 = document.createElement('td');
                const celda2 = document.createElement('td');
                const celda3 = document.createElement('td');
                const celda4 = document.createElement('td');
                const celda5 = document.createElement('td');

                const buttonModificar = document.createElement('button');
                const buttonEliminar = document.createElement('button');

                buttonModificar.classList.add('btn', 'btn-warning')
                buttonEliminar.classList.add('btn', 'btn-danger')
                buttonModificar.innerText = 'Modificar'
                buttonEliminar.innerText = 'Eliminar'

                buttonModificar.addEventListener('click', () => traerDatos(permiso))
                buttonEliminar.addEventListener('click', () => eliminar(permiso))

                celda1.innerText = contador;
                celda2.innerText = permiso.usu_nombre;
                celda3.innerText = permiso.rol_nombre;
                celda4.appendChild(btnModificar);
                celda5.appendChild(btnEliminar);

                tr.appendChild(celda1);
                tr.appendChild(celda2);
                tr.appendChild(celda3);
                tr.appendChild(celda4);
                tr.appendChild(celda5);

                fragment.appendChild(tr);
                contador++;
            });
        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.innerText = 'No hay permisos registrados';
            tr.classList.add('text-center');
            td.colSpan = 5;
            tr.appendChild(td);
            fragment.appendChild(tr);
        }
        tabla.tBodies[0].appendChild(fragment);
    } catch (error) {
        console.error('Error al buscar permisos:', error);
    }
};

const guardar = async (e) => {
    e.preventDefault();

    btnGuardar.disabled = true;

    if (!validarFormulario(formulario, ['permiso_id', 'permiso_usuario', 'permiso_rol'])) {
        btnGuardar.disabled = false;
        return;
    }

    try {
        const url = '/crud_autenticacion/API/permiso/guardar';
        const formData = new FormData(formulario);
        const respuesta = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const data = await respuesta.json();

        if (data.codigo === 1) {
            await Swal.fire({
                title: 'Éxito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            formulario.reset();
            Buscar();
        } else {
            await Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    } catch (error) {
        console.error('Error al guardar permiso:', error);
    } finally {
        BtnGuardar.disabled = false;
    }
};



const traerDatos = (permiso) => {
    console.log(permiso);
    formulario.permiso_id.value = permiso.permiso_id
    formulario.permiso_usuario.value = permiso.permiso_usuario
    formulario.permiso_rol.value = permiso.permiso_rol

    tabla.parentElement.parentElement.style.display = 'none'

    btnGuardar.parentElement.style.display = 'none'
    btnGuardar.disabled = true
    btnModificar.parentElement.style.display = ''
    btnModificar.disabled = false
    btnCancelar.parentElement.style.display = ''
    btnCancelar.disabled = false
}

const cancelar = (e) => {
    e.preventDefault();
    formulario.reset();
    btnGuardar.parentElement.classList.remove('d-none');
    btnModificar.parentElement.classList.add('d-none');
    btnCancelar.parentElement.classList.add('d-none');
};

const Modificar = async (e) => {
    e.preventDefault();

    BtnModificar.disabled = true;

    if (!validarFormulario(formulario, ['permiso_id', 'permiso_usuario', 'permiso_rol'])) {
        BtnModificar.disabled = false;
        return;
    }

    try {
        const url = '/crud_autenticacion/API/permiso/modificar';
        const formData = new FormData(formulario);
        const respuesta = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const data = await respuesta.json();

        if (data.codigo === 3) {
            await Swal.fire({
                title: 'Éxito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            formulario.reset();
            Buscar();
            btnGuardar.parentElement.classList.remove('d-none');
            btnModificar.parentElement.classList.add('d-none');
            btnCancelar.parentElement.classList.add('d-none');
        } else {
            await Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    } catch (error) {
        console.error('Error al modificar permiso:', error);
    } finally {
        btnModificar.disabled = false;
    }
};


const eliminar = async (permiso) => {
    try {
        const url = '/crud_autenticacion/API/permiso/eliminar';
        const formData = new FormData();
        formData.append('permiso_id', permiso.permiso_id);

        const respuesta = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const data = await respuesta.json();

        if (data.codigo === 4) {
            await Swal.fire({
                title: 'Éxito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            formulario.reset();
            Buscar();
            btnGuardar.parentElement.classList.remove('d-none');
            btnModificar.parentElement.classList.add('d-none');
            btnCancelar.parentElement.classList.add('d-none');
        } else {
            await Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    } catch (error) {
        console.error('Error al eliminar permiso:', error);
    }
};

Buscar();
formulario.addEventListener('submit', guardar);
btnCancelar.addEventListener('click', cancelar);
btnModificar.addEventListener('click', Modificar)


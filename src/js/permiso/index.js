import { Dropdown } from 'bootstrap';
import { Toast, validarFormulario } from "../funciones";
import Swal from "sweetalert2";

const formulario = document.getElementById('formPermiso');
const tabla = document.getElementById('tablaPermiso');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const selectUsuario = document.getElementById('permiso_usuario');
const selectRol = document.getElementById('permiso_rol');

btnModificar.parentElement.style.display = 'none';
btnModificar.disabled = true;
btnCancelar.parentElement.style.display = 'none';
btnCancelar.disabled = true;

const guardar = async (e) => {
    e.preventDefault();

    if (!validarFormulario(formulario, ['permiso_id'])) {
        Swal.fire({
            title: "Campos vacíos",
            text: "Debe llenar todos los campos",
            icon: "info"
        });
        return;
    }

    try {
        const body = new FormData(formulario);
        for (let pair of body.entries()) {
            console.log(pair[0] + ': ' + pair[1]); 
        }

        const url = "/crud_autenticacion/API/permiso/guardar";
        const config = {
            method: 'POST',
            body
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log('Respuesta del servidor:', data); 

        const { codigo, mensaje } = data;
        let icon = 'info';

        if (codigo == 1) {
            icon = 'success';
            formulario.reset();
            buscar();
        } else {
            icon = 'error';
            console.log(data.detalle);
        }

        Toast.fire({
            icon: icon,
            title: mensaje
        });
    } catch (error) {
        console.log('Error en la solicitud:', error);
    }
};



const cargarUsuariosYRoles = async () => {
    try {
        const urlUsuarios = "/crud_autenticacion/API/usuario/buscar";
        const urlRoles = "/crud_autenticacion/API/rol/buscar";
        const [respuestaUsuarios, respuestaRoles] = await Promise.all([fetch(urlUsuarios), fetch(urlRoles)]);

        const dataUsuarios = await respuestaUsuarios.json();
        const dataRoles = await respuestaRoles.json();

        if (dataUsuarios.codigo == 1) {
            selectUsuario.innerHTML = '<option value="">Seleccionar Usuario</option>'; 
            dataUsuarios.datos.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.usu_id;
                option.textContent = usuario.usu_nombre;
                selectUsuario.appendChild(option);
            });
        }

        if (dataRoles.codigo == 1) {
            selectRol.innerHTML = '<option value="">Seleccionar Rol</option>'; 
            dataRoles.datos.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol.rol_id;
                option.textContent = rol.rol_nombre;
                selectRol.appendChild(option);
            });
        }
    } catch (error) {
        console.log("Error al cargar usuarios y roles:", error);
    }
};

const buscar = async () => {
    try {
        const url = "/crud_autenticacion/API/permiso/buscar";
        const config = {
            method: 'GET',
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { codigo, datos } = data;
        tabla.tBodies[0].innerHTML = '';
        const fragment = document.createDocumentFragment();

        if (codigo == 1) {
            let counter = 1;
            datos.forEach(permiso => {
                const tr = document.createElement('tr');
                const td1 = document.createElement('td');
                const td2 = document.createElement('td');
                const td3 = document.createElement('td');
                const td4 = document.createElement('td');
                const td5 = document.createElement('td');
                const buttonModificar = document.createElement('button');
                const buttonEliminar = document.createElement('button');

                td1.innerText = counter;
                td2.innerText = permiso.nombre_usuario;
                td3.innerText = permiso.nombre_rol;

                buttonModificar.classList.add('btn', 'btn-warning');
                buttonEliminar.classList.add('btn', 'btn-danger');
                buttonModificar.innerText = 'Modificar';
                buttonEliminar.innerText = 'Eliminar';

                buttonModificar.addEventListener('click', () => traerDatos(permiso));
                buttonEliminar.addEventListener('click', () => eliminar(permiso));

                td4.appendChild(buttonModificar);
                td5.appendChild(buttonEliminar);

                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                fragment.appendChild(tr);

                counter++;
            });
        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.innerText = "No hay permisos";
            td.colSpan = 5;
            tr.appendChild(td);
            fragment.appendChild(tr);
        }

        tabla.tBodies[0].appendChild(fragment);

    } catch (error) {
        console.log(error);
    }
};
buscar();

const traerDatos = (permiso) => {
    formulario.permiso_id.value = permiso.permiso_id;

    // Establecer el valor correcto del usuario
    selectUsuario.value = permiso.permiso_usuario; 

    // Establecer el valor correcto del rol
    selectRol.value = permiso.permiso_rol;

    btnGuardar.parentElement.style.display = 'none';
    btnGuardar.disabled = true;
    btnModificar.parentElement.style.display = '';
    btnModificar.disabled = false;
    btnCancelar.parentElement.style.display = '';
    btnCancelar.disabled = false;
};


const cancelar = () => {
    formulario.reset();
    btnGuardar.parentElement.style.display = '';
    btnGuardar.disabled = false;
    btnModificar.parentElement.style.display = 'none';
    btnModificar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
};

const modificar = async (e) => {
    e.preventDefault();

    if (!validarFormulario(formulario)) {
        Swal.fire({
            title: "Campos vacíos",
            text: "Debe llenar todos los campos",
            icon: "info"
        });
        return;
    }

    try {
        const body = new FormData(formulario);
        const url = "/crud_autenticacion/API/permiso/modificar";
        const config = {
            method: 'POST',
            body
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { codigo, mensaje } = data;
        let icon = 'info';

        if (codigo == 1) {
            icon = 'success';
            formulario.reset();
            buscar();
            cancelar();
        } else {
            icon = 'error';
            console.log(data.detalle);
        }

        Toast.fire({
            icon: icon,
            title: mensaje
        });

    } catch (error) {
        console.log(error);
    }
};

const eliminar = async (permiso) => {
    let confirmacion = await Swal.fire({
        icon: 'question',
        title: 'Confirmación',
        text: '¿Está seguro que desea eliminar este registro?',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    });

    if (confirmacion.isConfirmed) {
        try {
            const body = new FormData();
            body.append('permiso_id', permiso.permiso_id);
            const url = "/crud_autenticacion/API/permiso/eliminar";
            const config = {
                method: 'POST',
                body
            };

            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            const { codigo, mensaje } = data;
            let icon = 'info';

            if (codigo == 1) {
                icon = 'success';
                buscar();
            } else {
                icon = 'error';
                console.log(data.detalle);
            }

            Toast.fire({
                icon: icon,
                title: mensaje
            });

        } catch (error) {
            console.log(error);
        }
    }
};

formulario.addEventListener('submit', guardar);
btnCancelar.addEventListener('click', cancelar);
btnModificar.addEventListener('click', modificar);
document.addEventListener('DOMContentLoaded', cargarUsuariosYRoles);

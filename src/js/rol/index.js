import { Dropdown  } from 'bootstrap';
import { Toast, validarFormulario } from "../funciones";
import Swal from "sweetalert2";

const formulario = document.getElementById('formRol');
const tabla = document.getElementById('tablaRol');
const btnGuardar = document.getElementById('btnGuardar')
const btnModificar = document.getElementById('btnModificar')
const btnCancelar = document.getElementById('btnCancelar')
const app = document.getElementById('rol_app')

btnModificar.parentElement.style.display = 'none'
btnModificar.disabled = true
btnCancelar.parentElement.style.display = 'none'
btnCancelar.disabled = true

const guardar = async (e) => {
    e.preventDefault()

    
    if (!validarFormulario(formulario, ['rol_id'])) {
        Swal.fire({
            title: "Campos vacios",
            text: "Debe llenar todos los campos",
            icon: "info"
        })
        return
    }
    
    try {
        const body = new FormData(formulario)
        const url = "/crud_autenticacion/API/rol/guardar"
        const config = {
            method : 'POST',
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        if (codigo == 1) {
            icon = 'success'
             formulario.reset();
              buscar();
         } else {
             icon = 'error'
             console.log(detalle);
         }

         Toast.fire({
             icon: icon,
             title: mensaje
         })
    } catch (error) {
        console.log(error)
    }
}

const Apps = async () => {
    try {
        const url = "/crud_autenticacion/API/aplicacion/buscar";
        const config = {
            method: 'GET'
        };

        const respuesta = await fetch(url, config);

        if (!respuesta.ok) {
            throw new Error(`HTTP error! Status: ${respuesta.status}`);
        }

        const data = await respuesta.json();
        console.log('Respuesta de la API:', data);

       
        const resultados = data.datos;

        if (!Array.isArray(resultados)) {
            throw new Error('La propiedad "datos" no es un array');
        }

        const selectElement = document.getElementById('rol_app');
        if (!selectElement) {
            console.error('El elemento <select> con ID "rol_app" no se encuentra en el DOM.');
            return;
        }

        selectElement.innerHTML = '<option selected>Seleccionar App</option>';

        resultados.forEach(dato => {
            if (dato.app_id && dato.app_nombre) {
                let agregarOption = document.createElement('option');
                agregarOption.value = dato.app_id;  
                agregarOption.textContent = dato.app_nombre; 
                selectElement.appendChild(agregarOption);
            } else {
                console.error('Estructura de datos inválida', dato);
            }
        });
    } catch (error) {
        console.error('Error al obtener datos:', error);
    }
};


const buscar = async () => {
    try {
        const url = "/crud_autenticacion/API/rol/buscar"
        const config = {
            method: 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { codigo, mensaje, detalle, datos } = data;
        tabla.tBodies[0].innerHTML = ''
        const fragment = document.createDocumentFragment();
        console.log(datos);
        if (codigo == 1) {
            let counter = 1;
            datos.forEach(rol => {
                const tr = document.createElement('tr');
                const td1 = document.createElement('td');
                const td2 = document.createElement('td');
                const td3 = document.createElement('td');
                const td4 = document.createElement('td');
                const td5 = document.createElement('td');
                const td6 = document.createElement('td');
                const buttonModificar = document.createElement('button');
                const buttonEliminar = document.createElement('button');
                td1.innerText = counter
                td2.innerText = rol.rol_nombre
                td3.innerText = rol.rol_nombre_ct
                td4.innerText = rol.app_nombre

                buttonModificar.classList.add('btn', 'btn-warning')
                buttonEliminar.classList.add('btn', 'btn-danger')
                buttonModificar.innerText = 'Modificar'
                buttonEliminar.innerText = 'Eliminar'

                buttonModificar.addEventListener('click', () => traerDatos(rol))
                buttonEliminar.addEventListener('click', () => eliminar(rol))

                td5.appendChild(buttonModificar)
                td6.appendChild(buttonEliminar)

                counter++

                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                tr.appendChild(td4)
                tr.appendChild(td5)
                tr.appendChild(td6)
                fragment.appendChild(tr)
            })
        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.innerText = "No hay roles"
            td.colSpan = 4

            tr.appendChild(td)
            fragment.appendChild(tr)
        }

        tabla.tBodies[0].appendChild(fragment)

    } catch (error) {
        console.log(error);
    }
}
buscar();

const traerDatos = (rol) => {
    console.log(rol);
    formulario.rol_id.value = rol.rol_id;
    formulario.rol_nombre.value = rol.rol_nombre;
    formulario.rol_nombre_ct.value = rol.rol_nombre_ct;

    // Buscar y seleccionar la opción correcta en el select basado en rol_app (que debería ser el id de la aplicación)
    const selectApp = formulario.rol_app;
    const optionToSelect = Array.from(selectApp.options).find(option => option.text === rol.app_nombre);

    if (optionToSelect) {
        selectApp.value = optionToSelect.value;
    } else {
        selectApp.value = ''; // Valor por defecto si no se encuentra la opción
    }

    tabla.parentElement.parentElement.style.display = 'none';

    btnGuardar.parentElement.style.display = 'none';
    btnGuardar.disabled = true;
    btnModificar.parentElement.style.display = '';
    btnModificar.disabled = false;
    btnCancelar.parentElement.style.display = '';
    btnCancelar.disabled = false;
};


const cancelar = () => {
    tabla.parentElement.parentElement.style.display = ''
    formulario.reset();
    btnGuardar.parentElement.style.display = ''
    btnGuardar.disabled = false
    btnModificar.parentElement.style.display = 'none'
    btnModificar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
}

const modificar = async (e) => {
    e.preventDefault()

    if (!validarFormulario(formulario)) {
        Swal.fire({
            title: "Campos vacios",
            text: "Debe llenar todos los campos",
            icon: "info"
        })
        return
    }

    try {
        const body = new FormData(formulario)
        const url = "/crud_autenticacion/API/rol/modificar"
        const config = {
            method: 'POST',
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { codigo, mensaje, detalle } = data;
        console.log(data);
        let icon = 'info'
        if (codigo == 1) {
            icon = 'success'
            formulario.reset();
            buscar();
            cancelar();
        } else {
            icon = 'error'
            console.log(detalle);
        }

        Toast.fire({
            icon: icon,
            title: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const eliminar = async (rol) => {
    let confirmacion = await Swal.fire({
        icon: 'question',
        title: 'Confirmacion',
        text: '¿Esta seguro que desea eliminar este registro?',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'No, cancelar',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    });

    if (confirmacion.isConfirmed) {
        try {
            const body = new FormData();
            body.append('rol_id', rol.rol_id);
            const url = "/crud_autenticacion/API/rol/eliminar";
            const config = {
                method: 'POST',
                body
            };

            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            const { codigo, mensaje, detalle } = data;
            let icon = 'info';
            if (codigo == 1) {
                icon = 'success';
                formulario.reset();
                buscar();
            } else {
                icon = 'error';
                console.log(detalle);
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



formulario.addEventListener('submit', guardar)
btnCancelar.addEventListener('click', cancelar)
btnModificar.addEventListener('click', modificar)
document.addEventListener('DOMContentLoaded', Apps);
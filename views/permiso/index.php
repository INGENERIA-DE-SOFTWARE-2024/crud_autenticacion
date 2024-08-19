<h1 class="text-center mb-4">FORMULARIO DE PERMISOS</h1>
<div class="row justify-content-center">
    <div class="border shadow p-4 col-lg-6 text-center">
        <form id="formPermiso">
            <input type="hidden" name="permiso_id" id="permiso_id">
            <div class="row mb-3">

                <div class="form-group mb-3">
                    <label for="permiso_usuario">Usuarios</label>
                    <select class="form-select mt-2" id="permiso_usuario" name="permiso_usuario">
                        <option selected>Seleccionar Usuario</option>
                    </select>

                </div>

                <div class="form-group mb-3">
                    <label for="permiso_rol">Roles</label>
                    <select class="form-select mt-2" id="permiso_rol" name="permiso_rol">
                        <option selected>Seleccionar Roles</option>
                    </select>

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
                </div>
                <div class="col">
                    <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
                </div>
                <div class="col">
                    <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-12 table-responsive">
        <h2 class="text-center mt-3">Listado de permisos</h2>
        <table class="table table-bordered table-hover" id="tablaPermiso">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Acción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script src="<?= asset('./build/js/permiso/index.js') ?>"></script>
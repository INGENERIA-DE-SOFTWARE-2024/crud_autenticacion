
<h1 class="text-center mb-4">FORMULARIO PARA INGRESAR ROLES</h1>
<div class="row justify-content-center">
    <div class="border shadow p-4 col-lg-6 text-center">
        <form id="formRol">
        <input type="hidden" name="rol_id" id="rol_id">
            <div class="row mb-3">
                <div class="row">
                <div class="col">
                    <label for="rol_nombre" class="form-label">Nombre del Rol</label>
                    <input type="text" name="rol_nombre" id="rol_nombre" class="form-control" placeholder="Administrador de tienda">
                </div>
                </div>
                <div class="row">
                <div class="col">
                    <label for="rol_nombre_ct" class="form-label">Código del rol</label>
                    <input type="text" name="rol_nombre_ct" id="rol_nombre_ct" class="form-control" placeholder="TIENDA_ADMIN">
                </div>
                </div>
               
                <div class="form-group mb-3">
                        <label for="rol_app">Apps existentes</label>
                        <select class="form-select mt-2" id="rol_app" name="rol_app">
                             <option selected>Seleccionar App</option>
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
        <h2 class="text-center mt-3">Listado de roles</h2>
        <table class="table table-bordered table-hover" id="tablaRol">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Nombre CT</th>
                    <th>App</th>
                    <th>Acción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script src="<?= asset('./build/js/rol/index.js') ?>"></script>
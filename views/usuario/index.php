<h1 class="text-center mb-4">FORMULARIO PARA INGRESAR USUARIOS</h1>
<div class="row justify-content-center">
    <div class="border shadow p-4 col-lg-6 text-center">
        <form id="formUsuario">
            <input type="hidden" name="usu_id" id="usu_id">
            <div class="row mb-3">
                <div class="row">
                <div class="col">
                    <label for="usu_nombre" class="form-label">Nombre del Usuario</label>
                    <input type="text" name="usu_nombre" id="usu_nombre" class="form-control" placeholder="Ingrese nombre del usuario">
                </div>
                </div>
                <div class="row">
                <div class="col">
                    <label for="usu_catalogo" class="form-label">Catálogo</label>
                    <input type="text" name="usu_catalogo" id="usu_catalogo" class="form-control" placeholder="Ingrese catálogo del usuario">
                </div>
                </div>
                <div class="row">
                <div class="col">
                    <label for="usu_password" class="form-label">Contraseña</label>
                    <input type="password" name="usu_password" id="usu_password" class="form-control" placeholder="Ingrese nombre del usuario">
                </div>
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
        <h2 class="text-center mt-3">Listado de usuarios</h2>
        <table class="table table-bordered table-hover" id="tablaUsuario">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Usuario</th>
                    <th>Catálogo</th>
                    <th>Contraseña</th>
                    <th>Acción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script src="<?= asset('./build/js/usuario/index.js') ?>"></script>
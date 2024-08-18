<h1 class="text-center mb-4">FORMULARIO PARA INGRESAR APLICACIONES</h1>
<div class="row justify-content-center">
    <div class="border shadow p-4 col-lg-6 text-center">
        <form id="formAplicacion">
            <input type="hidden" name="app_id" id="app_id">
            <div class="row mb-3">
                <div class="col">
                    <label for="app_nombre" class="form-label">Nombre de la Aplicación</label>
                    <input type="text" name="app_nombre" id="app_nombre" class="form-control" placeholder="Ingrese el nombre de aplicación">
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
        <h2 class="text-center mt-3">Listado de aplicaciones</h2>
        <table class="table table-bordered table-hover" id="tablaAplicacion">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
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
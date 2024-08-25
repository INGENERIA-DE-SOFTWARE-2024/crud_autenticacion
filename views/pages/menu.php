<h1>Usted es un ADMINISTRADOR</h1>
<a href="/crud_autenticacion/logout" class="btn btn-danger">Salir</a>



<?php if ($_SESSION['user']['rol_nombre_ct'] == 'ADMINISTRADOR_LOGIN') : ?>
    <p>Usuario administrador</p>

    <?php var_dump($_SESSION) ?>
<?php endif ?>
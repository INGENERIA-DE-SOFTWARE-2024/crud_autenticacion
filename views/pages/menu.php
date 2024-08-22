<h1>Menu principal de la APP</h1>
<a href="/login_test/logout" class="btn btn-danger">Salir</a>

<?php if ($_SESSION['user']['rol_nombre_ct'] == 'TIENDA_ADMIN') : ?>
    <p>Usuario administrador</p>

    <?php var_dump($_SESSION) ?>
<?php endif ?>
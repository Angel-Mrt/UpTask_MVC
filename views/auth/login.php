<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <?php
        $resultado = $_GET['resultado'] ?? '';

        if ($resultado === '1' || $resultado === '2' || $resultado === '3') {
            $mensaje = mostrarNotificacion(intval($resultado));
            if ($mensaje) { ?>
                <p class="alerta exito"> <?php echo s($mensaje) ?> </p>
            <?php }
        } else if ($resultado === '4') {
            $mensaje = mostrarNotificacion(intval($resultado));
            if ($mensaje) { ?>
                <p class="alerta error"> <?php echo s($mensaje) ?> </p>
        <?php }
        }
        ?>

        <p class="descripcion-pagina">Iniciar Sesion</p>

        <form action="/" method="POST" class="formulario">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu Email" name="email">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Tu Password" name="password">
            </div>
            <input type="submit" class="boton" value="Iniciar Sesion">
        </form>
        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div><!-- contenedor-sm --->
</div>
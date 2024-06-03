<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <p class="descripcion-pagina">Ingresa tu Email para recuperar tu Password</p>

        <form action="/olvide" method="POST" class="formulario" novalidate>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu Email" name="email">
            </div>
            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicar Sesion</a>
            <a href="/crear">¿Aun no tienes una cuenta? Crear Una</a>
        </div>
    </div><!-- contenedor-sm --->
</div>
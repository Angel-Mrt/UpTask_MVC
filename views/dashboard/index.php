<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<?php if (count($proyectos) === 0) { ?>
    <div class="contenedor-no-proyectos">
        <p class="descripcion">
            Aun No Tienes Proyectos
        </p>
        <a href="/crear-proyecto" class="crear-proyecto boton">Comenzar a Crear</a>
    </div>

<?php } else { ?>
    <ul class="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) { ?>
            <li class="proyecto">
                <a href="/proyecto?id=<?php echo $proyecto->url; ?>"><?php echo $proyecto->proyecto; ?></a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
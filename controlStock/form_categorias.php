<?php
$titulo = '';

if ($pagina === 'nueva-categoria') {
    $titulo = 'Nueva Categoria';

} elseif ($pagina === 'modificar-categoria') {
    $titulo = 'Modificar Categoria';
}
?>

<section>
    <!-- Titulo y boton atras -->
    <div class="bloque-titulo_boton">
        <h2 class="titulo">
            <?php echo $titulo ?>
        </h2>
        <a href="index.php">
            <div class="boton-primario btn btn-primary">Volver</div>
        </a>
    </div>

    <!-- Reproduccion de errores en pantalla -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- Reproduccion de alerta satisfactoria -->
    <?php if (intVal($state) === 1): ?>
        <div class="alerta succes">
            <?php echo "Categoria Modificada Correctamente"; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario categorias -->
    <div class="contenido-formulario">
        <form class="formulario" method="post">
            <div>
                <label class="formulario-label">Nombre:</label>
                <input class="formulario-input" type="text" value="<?php echo $nombre_categoria ?>" name="nombre">
            </div>

            <div>
                <label class="formulario-label">Descripcion:</label>
                <input class="formulario-input" type="text" value="<?php echo $descripcion_categoria ?>" name="descripcion">
            </div>

            <?php if ($pagina == 'nueva-categoria'): ?>
                <input class="boton-primario btn btn-primary" type="submit" value="Insertar" name="insertar">
            <?php elseif ($pagina == 'modificar-categoria'): ?>
                <input class="boton-primario btn btn-danger" type="submit" value="Borrar" name="borrar">
                <input class="boton-primario btn btn-warning" type="submit" value="Modificar" name="modificar">
                <input type="hidden" name="id" value="<?php echo $categoria['id'] ?>">
            <?php endif; ?>
        </form>
    </div>
</section>
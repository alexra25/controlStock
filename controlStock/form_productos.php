<?php
$titulo = '';

if ($pagina === 'nuevo-producto') {
    $titulo = 'Nuevo Producto';
    $redireccion = 'productos.php';

} elseif ($pagina === 'modificar-producto') {
    $titulo = 'Modificar Producto';
    $redireccion = "producto-cantidad.php?id=" . $producto['id'];
}
?>

<section>
    <!-- Titulo y boton atras -->
    <div class="bloque-titulo_boton">
        <h2 class="titulo">
            <?php echo $titulo; ?>
        </h2>
        <a href="<?php echo $redireccion;?>">
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
    <?php if (intval($state) === 2): ?>
        <div class="alerta succes">
            <?php echo "Producto modificado correctamente"; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario productos -->
    <div class="contenido-formulario">
        <form class="formulario" method="post">
            <div>
                <label class="formulario-label">Nombre:</label>
                <input class="formulario-input" type="text" placeholder="Nombre Producto" name="nombre"
                    value="<?php echo $nombre_producto ?>">
            </div>

            <div>
                <label class="formulario-label">Categoria:</label>
                <select class="formulario-input formulario-select" name="id_categoria">
                    <option value="">--Seleccionar--</option>
                    <?php while ($categoria = mysqli_fetch_assoc($resultados_categorias)): ?>
                        <option <?php echo $id_categoria === $categoria['id'] ? 'selected' : ''; ?>
                            value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="formulario-label">Departamento:</label>
                <select class="formulario-input formulario-select" name="id_departamento">
                    <option value="">--Seleccionar--</option>
                    <?php while ($departamento = mysqli_fetch_assoc($resultados_departamentos)): ?>
                        <option <?php echo $id_departamento === $departamento['id'] ? 'selected' : ''; ?>
                            value="<?php echo $departamento['id']; ?>"><?php echo $departamento['departamento']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="formulario-label">Stock Min:</label>
                <input class="formulario-input" type="number" placeholder="Stock minimo del Producto" name="stock_min"
                    value="<?php echo $stock_producto ?>">
                <!-- esta en tipo texto porque no consigo quitar las flechas de decoracion-->
            </div>

            <div>
                <label class="formulario-label">Cantidad:</label>
                <input class="formulario-input" type="number" placeholder="Cantidad del Producto" name="cantidad"
                    value="<?php echo $cantidad_producto ?>">
                <!-- esta en tipo texto porque no consigo quitar las flechas de decoracion-->
            </div>

            <?php if ($pagina === 'nuevo-producto'): ?>
                <input class="boton-primario btn btn-primary" type="submit" value="Insertar" name="insertar">
            <?php elseif ($pagina === 'modificar-producto'): ?>
                <?php if(intval($id_rol) == 1 || intval($id_rol) == 2 || intval($id_rol) == 3):?>
                    <input class="boton-primario btn btn-danger" type="submit" value="Borrar" name="borrar">
                <?php endif; ?>
                <input class="boton-primario btn btn-warning" type="submit" value="Modificar" name="modificar">
                <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
            <?php endif; ?>
        </form>
    </div>
</section>
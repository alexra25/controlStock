<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$id = $_GET['id'];

$consulta_proveedor_producto = "SELECT prodProveedores.*, 
proveedores.*
FROM prodProveedores
INNER JOIN proveedores ON prodProveedores.id_proveedor = proveedores.id
INNER JOIN productos ON prodProveedores.id_producto = productos.id
WHERE productos.id = $id";
$resultado_proveedor_producto = mysqli_query($conn, $consulta_proveedor_producto);

$consulta = "SELECT productos.*, 
             categorias.nombre AS nombre_categoria, 
             estados.nombre_estado AS nombre_estado, 
             departamentos.departamento AS nombre_departamento
             FROM productos
             INNER JOIN categorias ON productos.id_categoria = categorias.id
             INNER JOIN estados ON productos.id_estado = estados.id
             INNER JOIN departamentos ON productos.id_departamento = departamentos.id
             WHERE productos.id = $id";

$resultadoConsulta = mysqli_query($conn, $consulta);

$producto = mysqli_fetch_assoc($resultadoConsulta);

$state = 0;

$nombre_producto = $producto['nombre'];
$categoria_producto = $producto['nombre_categoria'];
$cantidad_producto = $producto['cantidad'];
//$referencia = $producto['referencia'];
$nombre_estado = $producto['nombre_estado']; // Cambio aquí
$id_proveedor = $producto['id_proveedor'];
$nombre_departamento = $producto['nombre_departamento']; // Cambio aquí
$stock_min = $producto['stock_min'];
$id_estado = $producto['id_estado'];

if (isset($_POST['actualizar'])) {

    $id_modificar = $_POST['id'];
    $cantidad_descontar = $_POST['descontar'];

    if ($cantidad_descontar > 0) {
        if (($cantidad_producto - $cantidad_descontar) < 0) {
            $state = 1;
        } else {
            $cantidad_producto -= $cantidad_descontar;

            if ($cantidad_producto <= $stock_min && $id_estado == 1) {
                echo "bajo stock";
                $id_estado = 2;
                $consulta_descontar = "UPDATE productos SET cantidad ='$cantidad_producto', id_estado = '$id_estado' WHERE id = $id_modificar";

                /*
                // notificar por email al jefe de departamento
                $to = 'fj.escamez@disengraf.com';
                $subject = 'Bajo stock del producto';
                $message = 'El producto ha entrado en estado de pendiente de stock';
                $headers = 'From: a.ruiz@disengraf.com' . "\r\n" .
                    'Reply-To: a.ruiz@disengraf.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                // Envía el correo electrónico
                $mailSent = mail($to, $subject, $message, $headers);

                if ($mailSent) {
                    echo 'El correo electrónico se ha enviado exitosamente.';
                } else {
                    echo 'Hubo un problema al enviar el correo electrónico.';
                }
                */

            } else {
                $consulta_descontar = "UPDATE productos SET cantidad ='$cantidad_producto' WHERE id = $id_modificar";
            }

            $resultados_descontar = mysqli_query($conn, $consulta_descontar);
            $state = 2;
        }
    } else {
        $state = 3;
    }
}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<section>
    <div class="bloque-titulo_boton">
        <h2 class="titulo">
            <?php echo strtoupper($nombre_producto . " - " . $categoria_producto); ?>
        </h2>
        <a href="productos.php">
            <div class="boton-primario btn btn-primary">Volver</div>
        </a>
    </div>

    <?php if (intval($state) === 1): ?>
        <div class="alerta error">
            <?php echo "No se puede descontar"; ?>
        </div>
    <?php elseif (intval($state) === 2): ?>
        <div class="alerta succes">
            <?php echo "Cantidad descontada"; ?>
        </div>
    <?php elseif (intval($state) === 3): ?>
        <div class="alerta error">
            <?php echo "No se ha indicado ninguna cantidad"; ?>
        </div>
    <?php endif; ?>

    <div class="contenido-formulario">
        <form class="formulario" method="post">
            <div>
                <label class="formulario-label">Estado:</label>
                <input class="formulario-input" type="text" value="<?php echo $nombre_estado ?>" disabled>
            </div>

            <div>
                <label class="formulario-label">Departamento:</label>
                <input class="formulario-input" type="text" value="<?php echo $nombre_departamento ?>" disabled>
            </div>

            <div>
                <label class="formulario-label">Stock Mínimo:</label>
                <input class="formulario-input" type="number" value="<?php echo $stock_min ?>" disabled>
            </div>

            <div>
                <label class="formulario-label">Stock Actual:</label>
                <input class="formulario-input" type="number" value="<?php echo $cantidad_producto ?>" placeholder="5"
                    disabled>
            </div>

            <div>
                <label class="formulario-label">Descontar:</label>
                <input class="formulario-input" type="number" name="descontar" placeholder="0" min="0">
            </div>
            <a href="modificar-producto.php?id=<?php echo $producto['id'] ?>">
                <div class="btn btn-warning">Incidencia</div>
            </a>
            <?php if(intval($id_rol) == 1 || intval($id_rol) == 2 || intval($id_rol) == 3):?>
                <a href="modificar-producto.php?id=<?php echo $producto['id'] ?>">
                    <div class="btn btn-warning">Modificar</div>
                </a>
            <?php endif; ?>
            <input class="boton-primario btn btn-secondary" type="submit" value="Actualizar" name="actualizar">
            <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
            <input type="hidden" name="stock_min" value="<?php echo $producto['stock_min'] ?>">
            <input type="hidden" name="id_estado" value="<?php echo $producto['id_estado'] ?>">
        </form>
    </div>

        <!-- tabla de proveedores -->
        <?php if(intval($id_rol) == 1):?>
            <div class="bloque-titulo_boton">
        <h2 class="titulo">Proveedores</h2>
        <a href="proveedor-producto.php?id=<?php echo $id ?>">
            <div class="boton-primario btn btn-primary">Modificar</div>
        </a>
    </div>
    <table class="tabla-productos2">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Contacto</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($proveedor = mysqli_fetch_assoc($resultado_proveedor_producto)): ?>
                <tr>
                    <td>
                        <?php echo $proveedor['proveedor']; ?>
                    </td>

                    <td>
                        <?php echo $proveedor['telefono']; ?>
                    </td>

                    <td>
                        <?php echo $proveedor['correo']; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>

</section>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>
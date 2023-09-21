<?php
include "conexion.php";
include "sesion.php";


$id = $_GET['id'];

$consulta_producto = "SELECT * FROM productos WHERE id = $id";
$resultado_producto = mysqli_query($conn, $consulta_producto);
$producto = mysqli_fetch_assoc($resultado_producto);

$consulta_proveedor_producto = "SELECT prodProveedores.*, 
prodProveedores.id AS id_registro,
proveedores.*
FROM prodProveedores
INNER JOIN proveedores ON prodProveedores.id_proveedor = proveedores.id
INNER JOIN productos ON prodProveedores.id_producto = productos.id
WHERE productos.id = $id";
$resultado_proveedor_producto = mysqli_query($conn, $consulta_proveedor_producto);

$consulta_proveedores = "SELECT prodProveedores.*, 
             proveedores.*
             FROM prodProveedores
             INNER JOIN proveedores ON prodProveedores.id_proveedor = proveedores.id
             INNER JOIN productos ON prodProveedores.id_producto = productos.id
             WHERE productos.id = $id";

$consulta_proveedores = "SELECT * FROM proveedores";

$resultado_proveedores = mysqli_query($conn, $consulta_proveedores);

if (isset($_POST['quitar'])) {
    $id_producto_proveedor = $_POST['id_producto_proveedor'];
    $consulta_eliminar = "DELETE FROM prodProveedores WHERE id = $id_producto_proveedor";
    mysqli_query($conn, $consulta_eliminar);
    header("Location: proveedor-producto.php?id=" . $id);
}

if (isset($_POST['agregar'])) {
    // Si se hizo clic en el botón "añadir", agrega un registro en la tabla prodProveedores
    $id_proveedor = $_POST['id_proveedor'];

    // Verifica si el registro ya existe antes de agregarlo
    $consulta_existencia = "SELECT * FROM prodProveedores WHERE id_producto = $id AND id_proveedor = $id_proveedor";
    $resultado_existencia = mysqli_query($conn, $consulta_existencia);

    if (mysqli_num_rows($resultado_existencia) == 0) {
        // Si el registro no existe, agrégalo
        $consulta_agregar = "INSERT INTO prodProveedores (id_producto, id_proveedor) VALUES ($id, $id_proveedor)";
        mysqli_query($conn, $consulta_agregar);
        header("Location: proveedor-producto.php?id=" . $id);
    }
}


$conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>
        <section>
            <!-- proveedores producto -->
            <div class="bloque-titulo_boton">
                <h2 class="titulo">
                    <?php echo "Poveedores - " . $producto['nombre']; ?>
                </h2>
                <a href="producto-cantidad.php?id=<?php echo $id ?>">
                    <div class="boton-primario btn btn-primary">Volver</div>
                </a>
            </div>
            <table class="tabla-productos2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>telefono</th>
                        <th>Email</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($proveedores_producto = mysqli_fetch_assoc($resultado_proveedor_producto)):?>
                        <form method="post">
                            <tr>
                                <td><?php echo $proveedores_producto['id']; ?></td>
                                <td><?php echo $proveedores_producto['proveedor']; ?></td>
                                <td><?php echo $proveedores_producto['direccion'];?></td>
                                <td><?php echo $proveedores_producto['telefono']; ?></td>
                                <td><?php echo $proveedores_producto['correo']; ?></td>
                                <td><button type="submit" name="quitar">Quitar</button></td>
                                <input type="hidden" name="id_producto_proveedor" value="<?php echo $proveedores_producto['id_registro'] ?>">
                            </tr>
                        </form>
                    <?php endwhile;?>
                </tbody>
            </table>

            <!-- lista de proveedores -->
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Lista de Poveedores</h2>
            </div>
            <table class="tabla-productos2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>telefono</th>
                        <th>Email</th>
                        <th>Añadir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($proveedores = mysqli_fetch_assoc($resultado_proveedores)):?>
                        <form method="post">
                            <tr>
                                <td><?php echo $proveedores['id']; ?></td>
                                <td><?php echo $proveedores['proveedor']; ?></td>
                                <td><?php echo $proveedores['direccion'];?></td>
                                <td><?php echo $proveedores['telefono']; ?></td>
                                <td><?php echo $proveedores['correo']; ?></td>
                                <td><button type="submit" name="agregar">Añadir</button></td>
                                <input type="hidden" name="id_proveedor" value="<?php echo $proveedores['id'] ?>">
                            </tr>
                        </form>
                    <?php endwhile;?>
                </tbody>
            </table>
        </section>
    </main>

        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>

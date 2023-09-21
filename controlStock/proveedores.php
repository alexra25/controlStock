<?php
include "conexion.php";
include "sesion.php";

$consulta = "SELECT * FROM proveedores";

$resultadoConsulta = mysqli_query($conn, $consulta);

$conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>
        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Proveedores</h2>
                <a href="nuevo-proveedor.php">
                    <div class="boton-primario btn btn-primary">Añadir</div>
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
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($proveedores = mysqli_fetch_assoc($resultadoConsulta)):?>
                        <tr>
                            <td><?php echo $proveedores['id']; ?></td>
                            <td><?php echo $proveedores['proveedor']; ?></td>
                            <td><?php echo $proveedores['direccion'];?></td>
                            <td><?php echo $proveedores['telefono']; ?></td>
                            <td><?php echo $proveedores['correo']; ?></td>
                            <td><a href="modificar-proveedor.php?id=<?php echo $proveedores['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </section>
    </main>

        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>

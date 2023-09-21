<?php
include "conexion.php";
include "sesion.php";

$consulta = "SELECT * FROM usuarios";

$resultadoConsulta = mysqli_query($conn, $consulta);

$consulta2 = "SELECT departamento FROM departamentos";
$resultadoConsulta2 = mysqli_query($conn, $consulta2);
$departamentos = mysqli_fetch_assoc($resultadoConsulta2);

$conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Usuarios</h2>
                <a href="nuevo-usuario.php">
                    <div class="boton-primario btn btn-primary">Añadir</div>
                </a>
            </div>
            <table class="tabla-productos2">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Departamento</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($usuarios = mysqli_fetch_assoc($resultadoConsulta)):?>
                        <tr>
                            <td><?php echo $usuarios['nombre']; ?></td>
                            <td><?php echo $usuarios['apellido1'].' '.$usuarios['apellido2'] ; ?></td>
                            <td><?php echo $usuarios['username']; ?></td>
                            <td><?php echo $usuarios['email']; ?></td>
                            <td><?php echo $departamentos['departamento']; ?></td>
                            <td><a href="modificar-usuario.php?id=<?php echo $usuarios['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 2rem; color: black;"></i></a></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </section>
    </main>

        <!--Aqui va el pie de la pagina -->
        <?php include 'includes/footer.php'; ?>

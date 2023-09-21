<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

// consultar todos los departamentos
$consulta_departamentos = "SELECT * FROM departamentos";
$resultados_departamentos = mysqli_query($conn, $consulta_departamentos);
$titulo_pagina = "Productos";

//consultas para mostrar las tablas por filtros
$consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos
             INNER JOIN categorias ON productos.id_categoria = categorias.id";

if ($_GET) {
    $departamento = $_GET['departamento'];
    $consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos
    INNER JOIN categorias ON productos.id_categoria = categorias.id
    WHERE productos.id_departamento = $departamento";

    $consulta2 = "SELECT departamento FROM departamentos WHERE id = $departamento";
    $resultadoConsulta2 = mysqli_query($conn, $consulta2);
    $departamento_nom = mysqli_fetch_assoc($resultadoConsulta2);
    if ($departamento_nom) {
        $titulo_pagina = "Productos de " . $departamento_nom['departamento'];
    }
}

$resultadoConsulta = mysqli_query($conn, $consulta);


$conn->close();
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<section>
    <div class="bloque-titulo_boton">
        <h2 class="titulo"><?php echo $titulo_pagina ?></h2>
        <?php if (intval($id_rol) == 1 || intval($id_rol) == 2): ?>
            <a href="nuevo-producto.php">
                <div class="btn btn-primary boton-primario">Añadir</div>
            </a>
        <?php endif; ?>
    </div>

    <a class="boton boton-secundario" href="productos.php">Todos</a>
    <?php while ($departamento = mysqli_fetch_assoc($resultados_departamentos)): ?> 
        <a class="boton boton-secundario" 
        href="productos.php?departamento=<?php echo $departamento['id']?>"><?php echo $departamento['departamento']?></a>
    <?php endwhile; ?>

    <table class="tabla-productos2">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Abrir</th>
                <!--<th>Actualizar</th>
                <th>Modificar</th>-->
            </tr>
        </thead>
        <tbody>
            <?php while ($productos = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td>
                        <?php echo $productos['nombre']; ?>
                    </td>
                    <td>
                        <?php echo $productos['nombre_categoria']; ?>
                    </td>
                    <td>
                        <?php echo $productos['codigo']; ?>
                    </td>
                    <td>
                        <?php echo $productos['cantidad']; ?>
                    </td>
                    <td><a id="agregarContador" href="producto-cantidad.php?id=<?php echo $productos['id'] ?>"><i
                                class="bi bi-arrow-clockwise" style="font-size: 2rem; color: black;"></i></a></td>
                    <!--<td><a href="modificar-producto.php?id=<?php echo $productos['id'] ?>"><i class="bi bi-pencil-square"
                                style="font-size: 2rem; color: black;"></i></a></td>-->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>
<?php
include "conexion.php";
include "sesion.php";
include "includes/registrar.php";

$consulta_categorias = "SELECT * FROM Categorias";
$resultados_categorias = mysqli_query($conn, $consulta_categorias);

$consulta_departamentos = "SELECT * FROM departamentos";
$resultados_departamentos = mysqli_query($conn, $consulta_departamentos);

$id = $_GET['id'];

$consulta_cantidades ="SELECT SUM(pendiente_entrega) AS suma_pendiente_entrega
FROM seguimiento
WHERE id_producto = $id;";

$cantidades = mysqli_query($conn, $consulta_cantidades);
$resultado_cantidades = mysqli_fetch_assoc($cantidades);

$consulta = "SELECT * FROM productos WHERE id = ${'id'}";
$resultadoConsulta = mysqli_query($conn, $consulta);
$producto = mysqli_fetch_assoc($resultadoConsulta);
$state = 0;
$pagina = 'modificar-producto';

if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM productos WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    /*if ($resultados) {
        //setRegistro($nombre, 6, $id_usuario, $conn);

    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }*/
}

$nombre_producto = $producto['nombre'];
$id_categoria = $producto['id_categoria'];
$id_departamento = $producto['id_departamento'];
$stock_producto = $producto['stock_min'];
$cantidad_producto = $producto['cantidad'];

if (isset($_POST['modificar'])) {
    $id_modificar = $_POST['id'];
    $nombre_producto = $_POST['nombre'];
    $id_categoria = $_POST['id_categoria'];
    $id_departamento = $_POST['id_departamento'];
    $stock_producto = $_POST['stock_min'];
    $cantidad_producto = $_POST['cantidad'];

    if (!$nombre_producto) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$id_categoria) {
        $errores[] = "Debes añadir una categoria";
    }

    if (!$id_departamento) {
        $errores[] = "Debes añadir un departamento";
    }

    if (!$cantidad_producto) {
        $errores[] = "Debes añadir una cantidad";
    }

    if (!$stock_producto) {
        $errores[] = "Debes añadir una cantidad de stock minimo";
    }

    if (empty($errores)) {
        $consulta = "UPDATE productos SET nombre = '$nombre_producto', id_categoria = '$id_categoria', stock_min ='$stock_producto', cantidad ='$cantidad_producto' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 2;

        if ($resultados) {
            setRegistro($nombre, 5, $id_usuario,$id_categoria, $conn);

        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
    }
}
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!-- vinculo formulario -->
<?php include 'form_productos.php'; ?>
</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>
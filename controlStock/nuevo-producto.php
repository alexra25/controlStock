<?php
    include "conexion.php";
    include "sesion.php";
    include "includes/registrar.php";
    
    // consultar todas las categorias
    $consulta_categorias = "SELECT * FROM Categorias";
    $resultados_categorias = mysqli_query($conn, $consulta_categorias);

    $consulta_departamentos = "SELECT * FROM departamentos";
    $resultados_departamentos = mysqli_query($conn, $consulta_departamentos);

    $consulta_proveedores = "SELECT * FROM proveedores";
    $resultados_proveedores = mysqli_query($conn, $consulta_proveedores);

    
    // declarar variables de value
    $errorres = [];
    $nombre_producto = '';
    $id_categoria = '';
    $id_departamento = '';
    $cantidad_producto = '';
    $stock_min_producto = '';
    $pagina = 'nuevo-producto';
    $id_estado = 1;

    if (isset($_POST['insertar'])) { // Verifica si el formulario se ha enviado
    
        // Recogemos los valores donde los almacenamos y sanitizamos
        $nombre_producto = $_POST['nombre'];
        $id_categoria = $_POST['id_categoria'];
        $id_departamento = $_POST['id_departamento'];
        $cantidad_producto = $_POST['cantidad'];
        $stock_min_producto = $_POST['stock_min'];

        // Verificacion de formulario
        if(!$nombre_producto){
            $errores[] = "Debes añadir un nombre";
        }

        if(!$id_categoria){
            $errores[] = "Debes añadir una categoria";
        }

        if(!$id_departamento){
            $errores[] = "Debes añadir un departamento";
        }

        if(!$cantidad_producto){
            $errores[] = "Debes añadir una cantidad";
        }

        if(!$stock_min_producto){
            $errores[] = "Debes añadir una cantidad de stock minimo";
        }

        // revisar el array de errores y si esta vacio lo guarda en la base de datos
        if(empty($errores)){
            $consulta = "INSERT INTO productos (cantidad,nombre,stock_min,id_categoria,id_estado, id_departamento) values ('$cantidad_producto','$nombre_producto','$stock_min_producto','$id_categoria', '$id_estado', '$id_departamento')";
            $resultados = mysqli_query($conn, $consulta);
            
            $id_insertado = mysqli_insert_id($conn);
    
            if ($resultados) {
                setRegistro($nombre_producto, 4, $id_usuario,$id_categoria, $conn);

            } else {
                echo "Error al eliminar la categoría: " . mysqli_error($conn);
            }
        }

        // Cerrar la conexión cuando hayas terminado
        $conn->close();

    }
?>

<!-- vinculo de header y barra de navegacion -->
<?php include 'includes/header.php'; ?>

<!-- vinculo formulario -->
<?php include 'form_productos.php'; ?>


</main>

<!--Aqui va el pie de la pagina -->
<?php include 'includes/footer.php'; ?>
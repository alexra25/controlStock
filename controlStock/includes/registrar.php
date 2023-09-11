<?php
    function setRegistro($descripcion, $id_accion, $id_usuario, $conn) {
        $consulta = "INSERT INTO registro(descripcion, id_accion, id_usuario) 
        VALUES ('$descripcion','$id_accion','$id_usuario')";
        $resultados = mysqli_query($conn, $consulta);


        if ($resultados) {
            if (intval($id_accion) === 2 || intval($id_accion) === 3) {
                header("Location: categorias.php");
                exit();

            }elseif (intval($id_accion) === 4 || intval($id_accion) === 6) {
                header("Location: productos.php");
                exit();

            }elseif (intval($id_accion) === 7 || intval($id_accion) === 9 || intval($id_accion) === 11) {
                header("Location: seguimiento.php");
                exit();
            }
        }
    }
?>
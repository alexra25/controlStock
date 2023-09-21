<?php
    function setRegistro($descripcion, $id_accion, $id_usuario,$id_categoria,$con) {

        if(!isset($id_producto)){
            $consulta = "INSERT INTO registro(descripcion, id_accion, id_usuario,id_categoria) 
        VALUES ('$descripcion','$id_accion','$id_usuario','$id_categoria')";
              
        }else{
            $consulta = "INSERT INTO registro(descripcion, id_accion, id_usuario,id_producto,id_categoria) 
            VALUES ('$descripcion','$id_accion','$id_usuario','$id_producto','$id_categoria')";
        }
        
        $resultados =  $con->query($consulta);           


        if ($resultados) {
            if (intval($id_accion) === 2 || intval($id_accion) === 3) {
                header("Location: index.php");
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
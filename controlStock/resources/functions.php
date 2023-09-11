<?php   

    // crear registro de estado en la tabla registros
    function set_registro (){
        date_default_timezone_set("Europe/Madrid");
        $fecha = date("d/m/Y H:i");
        $id_producto = 5;
        $id_usuario = 8;
        $query = "INSERT INTO registro (fecha,descripcion,id_producto,id_usuario) values ('$fecha','Categoria Creada','$id_producto','$id_usuario')";
        $resultado = mysqli_query($conn, $query);
    }
?>
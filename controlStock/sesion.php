<?php

    session_start(); // Iniciar la sesión
    //comprobacion de que existe la variable sesion.
    if(isset($_SESSION['username'])){
        //Si existe puedes continuar trabajando.
        $username = $_SESSION['username'];
        $id_usuario = $_SESSION['id_usuario'];
        $id_rol = $_SESSION['id_rol'];
    }else{
        header("Location: inicio_sesion.php");
    }
    

    //session_destroy();
?>
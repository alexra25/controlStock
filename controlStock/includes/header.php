<?php
include "conexion.php";

$dosPrimerasLetras = str_replace('.', '', $_SESSION['username']);
$dosPrimerasLetras = substr($dosPrimerasLetras, 0, 2);
$inicial_usuario = strtoupper($dosPrimerasLetras);


//$consulta = "SELECT * FROM productos";
$consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria 
            FROM productos
            INNER JOIN categorias ON productos.id_categoria = categorias.id
            WHERE productos.cantidad <= productos.stock_min";

$resultadoNotificaciones = mysqli_query($conn, $consulta);
$count_notificaciones = mysqli_num_rows($resultadoNotificaciones);

$conn->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!--Links de bootstrap-->
    <link rel="stylesheet" href="./csss/bootstrap.min.css">
    <script src="./js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script>
        const cambiarTema = () => {
            const body = document.querySelector("body");
            const dlIcon = document.querySelector("#dl-icon");

            if (body.getAttribute("data-bs-theme") === "light") {
                body.setAttribute("data-bs-theme", "dark");
                dlIcon.setAttribute("class", "bi bi-sun-fill");
                dlIcon.classList.remove("text-white");
            } else {
                body.setAttribute("data-bs-theme", "light");
                dlIcon.setAttribute("class", "bi bi-moon-fill text-white");
            }
        }

    </script>
    <style>
        /* Estilo para ocultar inicialmente la sección de Control de Stock */
        .control-stock {
            display: none;
        }
    </style>

    <title>Control de stock</title>
</head>

<body data-bs-theme="light">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
      </symbol>

      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path
          d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"
        />
        <path
          d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"
        />
      </symbol>

      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path
          d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"
        />
      </symbol>
    </svg>
    <!--Aqui va el header con el buscador-->
    <header class="header">

        <button onclick="cambiarTema()" class="btn  -fill"><i id="dl-icon" class="bi bi-moon-fill"></i></button>

        <a class="contenido-usuario-enlace" href="cerrarSesion.php">
            <div class="contenido-usuario">
                <p class="contenido-usuario-nombre"><?php echo $_SESSION['nombre']; ?></p>
                <div class="contenido-usuario-logo">
                    <p class="contenido-usuario-inicial"><?php echo $inicial_usuario; ?></p>
                </div>            
            </div>
        </a>

    </header>

    <!--Aqui va el contenedor de la barra lateral y contenido principal -->
    <main class="main inicio">

        <!--Aqui va el navegador de la pagina con las secciones que tiene-->
        <nav class="navegacion bg-secondary">
            <button id="toggleControlStock">Control de Stock</button>

            <section class="control-stock">
                <div class="navContenedor">
                    <a href="index.php">Categorias</a>

                    <a href="productos.php">Productos</a>

                    <div class="contenedor-notificacion">
                        <a href="notificaciones.php">Notificaciones</a>
                        
                        <?php  if (intval($count_notificaciones) > 0): ?>
                            <div class="contador-notificacion">
                                <?php echo $count_notificaciones ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <a href="seguimiento.php">Seguimiento</a>

                    <a href="registro.php">Registro</a>

                    <?php if (intval($id_rol) == 1): ?>
                        <a href="usuarios.php">Usuarios</a>
                    <?php endif; ?>

                    <?php if (intval($id_rol) == 1): ?>
                        <a href="proveedores.php">Proveedores</a>
                    <?php endif; ?>
                </div>
            </section>
            <script>
                // Obtener el botón y la sección de Control de Stock
                var toggleButton = document.getElementById("toggleControlStock");
                var controlStockSection = document.querySelector(".control-stock");

                // Agregar un evento de clic al botón
                toggleButton.addEventListener("click", function () {
                    // Alternar la visibilidad de la sección de Control de Stock
                    if (controlStockSection.style.display === "none" || controlStockSection.style.display === "") {
                        controlStockSection.style.display = "block";
                    } else {
                        controlStockSection.style.display = "none";
                    }
                });
            </script>
        </nav>
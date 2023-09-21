<?php
    $titulo = "Proveedores";
?>

<section>
    <!-- Titulo y boton atras -->
    <div class="bloque-titulo_boton">
        <h2 class="titulo">
            <?php echo $titulo; ?>
        </h2>
        <a href="insertar-proveedor">
            <div class="boton-primario btn btn-primary">Insertar</div>
        </a>
    </div>

    <table class="tabla-productos2">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($proveedor = mysqli_fetch_assoc($resultados_proveedores)): ?>
                <tr>
                    <td>
                        <?php echo $proveedor['proveedor']; ?>
                    </td>

                    <td>
                        <?php echo $proveedor['correo']; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</section>
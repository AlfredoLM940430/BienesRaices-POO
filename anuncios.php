<?php 
    require 'includes/app.php';
    incTemplate('header');
?> 
<main class="contenedor seccion">

    <h2>Casas y Depas en Venta</h2>
    
    <?php 
        include 'includes/templates/anuncios.php'; 
    ?>
</main>

<?php 
incTemplate('footer');
?> 
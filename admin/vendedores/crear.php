<?php 

    require '../../includes/app.php';

    use App\Vendedor;
    Autenticado();

    $vendedor = new Vendedor;

    // Detectar errores
    $errores = Vendedor::getErrores();

    //Ejecucion del codigo al enviar el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Crear instancia
        $vendedor = new Vendedor($_POST['vendedor']);

        //Validar campos vacios
        $errores = $vendedor->validar();

        //Guardar si no existen errores
        if(empty($errores)){
            $vendedor->guardar();
        }
    }

incTemplate('header');
?> 


<main class="contenedor seccion">

    <h1>Registrar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>  
    <?php endforeach; ?>

    <!-- enctype="multipart/form-data" *Para Imagenes* -->
    <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        
    <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <div class="mgr">
            <input type="submit" value="Registrar vendedor" class="boton boton-verde">
        </div>

    </form>
    
</main>

<?php 
    //Cerrar conexion
    mysqli_close($db);
    incTemplate('footer');
?> 
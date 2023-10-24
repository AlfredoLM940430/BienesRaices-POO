<?php 

    require '../../includes/app.php';

    use App\Vendedor;

    Autenticado();

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
       header('Location: /admin'); 
    }

    //Obtener vendedor
    $vendedor = Vendedor::find($id);

    // Detectar errores
    $errores = Vendedor::getErrores();

    //Ejecucion del codigo al enviar el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        //Asignar valores
        $args = $_POST['vendedor'];

        //Sincronizar objetos en memoria con loq ue el usuario escribio
        $vendedor->sincronizar($args);

        //validacion
        $errores = $vendedor->validar();

        if(empty($errores)){
            $vendedor->guardar();
        }
    }

    incTemplate('header');
?> 


<main class="contenedor seccion">

    <h1>Actualizar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>  
    <?php endforeach; ?>

    <!-- enctype="multipart/form-data" *Para Imagenes* -->
    <form class="formulario" method="POST" enctype="multipart/form-data">
        
    <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <div class="mgr">
            <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        </div>

    </form>
    
</main>

<?php 
    //Cerrar conexion
    mysqli_close($db);
    incTemplate('footer');
?> 
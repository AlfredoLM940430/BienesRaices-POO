
<?php

use App\Propiedad;
use App\Vendedor;

use Intervention\Image\ImageManagerStatic as Image;

    require '../../includes/app.php';
    
    // Autenticado() desde funciones.php
    Autenticado();

    //Valida ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    // Obtener datos de la propiedad
    $propiedad = Propiedad::find($id);

    // Obtener datos del vendedor
    $vendedores = Vendedor::all();
    
    // Detectar errores
    $errores = Propiedad::getErrores();

    //Ejecucion del codigo al enviar el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Asignar atributos *name="propiedad[titulo]"* desde formulario_propiedades.php
        $args =$_POST['propiedad'];

        $propiedad->sincronizar($args);

        //Validacion
        $errores = $propiedad->validar();

        /* **Subida de archivos ** */
        //Nombre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        //Subida de archivos
        if($_FILES['propiedad']['tmp_name']['imagen']){

            $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        // Revision para insertar
        if(empty($errores)) {
            // Almacenar la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']) {

                $imagen->save(CARPETA_IMAGENES . $nombreImagen); 
            }
            $propiedad->guardar();
        }
    }

    incTemplate('header');
?> 

<main class="contenedor seccion">

    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>  
    <?php endforeach; ?>

    <!-- enctype="multipart/form-data" -->
    <form class="formulario" method="POST" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <div class="mgr">
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </div>

    </form>
    
</main>

<?php 
    //Cerrar conexion
    mysqli_close($db);
    incTemplate('footer');
?> 

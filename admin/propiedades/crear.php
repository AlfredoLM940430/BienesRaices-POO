
<?php 

    require '../../includes/app.php';

    //propiedad.php
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    // Autenticado() desde app.php -> funciones.php
    Autenticado();

    //Consulta vendedores
    $vendedores = Vendedor::all();

    // Detectar errores
    $errores = Propiedad::getErrores();

    $propiedad = new Propiedad;
    
    //Ejecucion del codigo al enviar el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        //Declarar nueva instancia ↑↑ use App\Propiedad;
        $propiedad = new Propiedad($_POST['propiedad']);

        //Nombre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
        //Setear imagen
        //Redimencionar imagen con intervention
        if($_FILES['propiedad']['tmp_name']['imagen']){

            $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
       
        //Validar
        $errores = $propiedad ->validar();

        // Revision para insertar
        if(empty($errores)){

            //Carpeta Imagenes
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //Guardar imagen
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            
            //Guardar datos
            $propiedad -> guardar();
        }
    }

    incTemplate('header');
?> 

<main class="contenedor seccion">

    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>  
    <?php endforeach; ?>

    <!-- enctype="multipart/form-data" -->
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        
    <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <div class="mgr">
            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </div>

    </form>
    
</main>

<?php 
    //Cerrar conexion
    mysqli_close($db);
    incTemplate('footer');
?> 
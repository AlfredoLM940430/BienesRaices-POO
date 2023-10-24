<?php 

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incTemplate(string $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/{$nombre}.php";
}

function Autenticado() {  

    //Informacion alamacenada en $_SESSION desde login L.40
    session_start();

    if(!$_SESSION['login']){
            header('Location: /');
    }  
}

// Ver codigo ejecutado
function debug($variable){
    
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapar HTML
function s($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

function validarContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

function Notificaciones($codigo){
    $mensaje = '';

    switch($codigo){
        case 1: 
            $mensaje = 'Registro Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Registro Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Registro Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}
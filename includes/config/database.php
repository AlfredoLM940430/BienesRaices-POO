<?php 

function conectarDB() : mysqli {
    $db = new mysqli('', '', '', '');
    
    if(!$db){
        echo "Error: No se pudo conectar a la base de datos";
        exit;
    }

    return $db;
}
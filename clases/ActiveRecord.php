<?php 

/* ** static busca la propiedad en vendedor o propiedad ** */

namespace App;

class ActiveRecord {
    
    public $id;
    public $imagen;

    //Base de datos
    protected static $db;

    //Identificar estructura de la db **Hereda de propiedad/vendedor.php
    protected static $columnasDB = '';
    
    // Hereda solicitudes de propiedad/vendedor.php
    protected static $tabla = '';

    //Errores
    protected static $errores = [];

    //Definir conexion db
    public static function setDB($database){
        self::$db = $database;
    }

    public function guardar(){

        if(!is_null($this->id)){
            
            //Actualizar
            $this->actualizar();

        }else{

            //crear
            $this->crear();
        }
    }

    public function crear(){
        
        //Sanitizar
        $atributos = $this->sanitizarDatos();
        
        //$string = join(', ', array_keys($atributos));
        //$string = join(', ', array_values($atributos));

        //Isertar en DataBase
        $query = "INSERT INTO " . static::$tabla . " ("; 
        //Conversion arreglo a cadena
        $query .= join(', ', array_keys($atributos));
        $query .= " )VALUES ('"; 
        //Conversion arreglo a cadna **valores
        $query .= join("', '", array_values($atributos));
        $query .= "');";

        $resultado = self::$db->query($query);

        if($resultado){
            //Redireccionar al guardarse correctamente
            header('Location: /admin?mensaje=Registro Correcto&registro=1');
        } 
    }

    public function actualizar(){
        
        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .=  " LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        if($resultado){
            header('Location: /admin?registro=2');
        }
    }
    
    //Eliminar
    public function eliminar(){
        //Eliminar en BD
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            header('Location: /admin?registro=3');
        }

    }

    // Identificar y unir atributos de la bd
    public function atributos(){
        $atributos = [];
        foreach (static::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        //arreglo asociativo
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen){
        
        //Elimina imagen previa
        if(!is_null($this->id)){
            
            $this->borrarImagen();
        }
        
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //Eliminar imagen
    public function borrarImagen(){
        //Comprobar si existe archibo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        // debug($existeArchivo);

        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Validacion de errores
    public static function getErrores(){
        
        return static::$errores;
    }

    public function validar(){

        static::$errores = [];
        return static::$errores;
    }

    //listar propiedades
    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }


        //Limite de registros
        public static function get($cantidad){
            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
    
            $resultado = self::consultarSQL($query);
    
            return $resultado;
        }

    //Busqueda de registro por ID
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        //Consultar
        $resultado = self::$db->query($query);

        //Iterar
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::Objeto($registro);
        }

        //Liberar memoria
        $resultado->free();

        //retornar resultados
        return $array;
    }

    //Convertir de arreglo a objeto
    protected static function Objeto($registro){

        //Crear nuevo constructor
        $objeto = new static;
        // debug($objeto);
        
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincroniza memoria datos nuevos *actualizar
    public function sincronizar($args=[]){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value) ){
                $this->$key = $value;
            }
        }
    }
}

// public *this->*
// static *self::$*
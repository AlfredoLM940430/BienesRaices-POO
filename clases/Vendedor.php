<?php 

namespace App;

class Vendedor extends ActiveRecord{

    protected static $tabla = 'vendedores';

    //Identificar estructura de la db 
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];  
    
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar(){
        
        if(!$this->nombre) {
            self::$errores [] = "El Nombre es Obligatorio";
        }

        if(!$this->apellido) {
            self::$errores [] = "El Apellido es Obligatorio";
        }

        if(!$this->telefono) {
            self::$errores [] = "El Telefono es Obligatorio";
        }

        //Expresion regular
        if(!preg_match('/[0-9]{10}/', $this->telefono)){
            self::$errores [] = "Telefono NO Valido";
        }

        return self::$errores;

    }

}
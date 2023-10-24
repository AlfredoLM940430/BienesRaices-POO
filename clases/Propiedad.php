<?php 

namespace App;

class Propiedad extends ActiveRecord{

    protected static $tabla = 'propiedades';

    //Identificar estructura de la db 
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar(){
        
        if(!$this->titulo) {
            self::$errores [] = "Debes Añadir un Titulo";
        }

        if(!$this->precio) {
            self::$errores [] = "El Precio es Obligatorio";
        }
        
        if(strlen($this->descripcion < 10)) {     //Extencion minina
            self::$errores [] = "Es Obligatorio Añadir una Pequeña Descripcion";
        }

        if(!$this->habitaciones) {
            self::$errores [] = "El Numero de Habitaciones no debe estar Vacio";
        }

        if(!$this->wc) {
            self::$errores [] = "El Numero de baños no debe estar Vacio";
        }

        if(!$this->estacionamiento) {
            self::$errores [] = "El Numero de Espacios de en el Estacionamiento no debe estar Vacio";
        }

        if(!$this->vendedores_id) {
            self::$errores [] = "Elije un Vendedor";
        }
        // Imagen
        if(!$this->imagen){
            self::$errores [] = 'Imagen obligatoria';
        }
        
        return self::$errores;

    }
}

// public *this->*
// static *self::$*
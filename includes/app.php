<?php 

// Llama funciones.php
require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Conectar db
$db = conectarDB();

//Desde carpeta clases
use App\ActiveRecord;

//Referencia db direccion activerecord
ActiveRecord::setDB($db);



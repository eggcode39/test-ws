<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 16/06/2022
 * Time: 18:44
 */
//Inicio del código
try{
    //Establecer zona horaria
    date_default_timezone_set('America/Lima');

    //Para Mostrar o No Errores (Comentado Para SI, Descomentado Para NO)
    //error_reporting(E_ALL);
    //Variables Globales
    require 'core/globals.php';
    //Levantamiento del Log para registro de errores
    require 'app/models/Log.php';
    //LLamada a archivo gestor de base de datos
    require 'core/Database.php';

    //Inicialización de clases necesarias
    $error = new Log();

    // Manejo de Errores Personalizado de PHP para Try/Catch
    function exception_error_handler($severidad, $mensaje, $fichero, $linea) {
        $cadena =  '[LEVEL]: ' . $severidad . ' IN ' . $fichero . ': ' . $linea . '[MESSAGGE]' . $mensaje . "\n";
        $guardar = new Log();
        $guardar->insert($cadena, "Excepcion No Manejada");
    }

    //Para manejo de caracteres (Por defecto utf-8)
    header("Content-Type: text/html;charset=utf-8");
    //Declarar el uso de manejo de Error con la Función que declaramos
    set_error_handler("exception_error_handler");

    //Inicialización de Variables Para Recepción de Parámetros $_GET
    $controlador = "";
    $accion = "";

    //Recepción del Controlador Enviado
    if(isset($_GET['c'])){
        //Aqui se recibe el controlador, si está declarado
        $controlador = 'Test';
        //Tratamiento de Caracteres
        $controlador = trim(ucfirst($controlador));
        $controlador = filter_var($controlador, FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        //Si no hay Controlador declarado, se genera error y se detiene el código
        $controlador = 'Test';
        //Tratamiento de Caracteres
        $controlador = trim(ucfirst($controlador));
        $controlador = filter_var($controlador, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    //Recepción de la Función/Acción Enviada
    if(isset($_GET['a'])){
        //Aqui la Función/Acción, si está declarado
        $accion = 'registrar';
        //Tratamiento de Caracteres
        $accion = trim(strtolower($accion));
        $accion = filter_var($accion, FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        //Si no hay Función/Acción declarada, se genera error y se detiene el código
        $accion = 'registrar';
        //Tratamiento de Caracteres
        $accion = trim(strtolower($accion));
        $accion = filter_var($accion, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    //Verificar Existencia del Controlador Solicitado
    $archivo = 'app/controllers/' . $controlador . 'Controller.php';
    if(file_exists($archivo)){
        //Declaración de la Clase a Llamar
        $clase = sprintf('%sController', $controlador);
        try{
            require $archivo;
            $controller = new $clase;
            $controller->$accion();
        } catch (Exception $e){
            $response = array("code" => 2,"message" => 'TOKEN INVALIDO');
            $data = array("result" => $response);
            echo json_encode($data);
        }
    } else {
        //Si no existe el Controlador Solicitado, se genera Error
        $response = array("code" => 2,"message" => 'INVALIDO');
        $data = array("result" => $response);
        echo json_encode($data);
    }
} catch (Exception $e){
    //Si Ocurriera Algún Error Durante la Ejecución del Código, Se Usarán Estas Líneas de Código
    $response = array("code" => 2,"message" => 'INVALIDO');
    $data = array("result" => $response);
    echo json_encode($data);
}
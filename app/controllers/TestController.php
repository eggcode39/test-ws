<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 16/06/2022
 * Time: 18:23
 */
require 'app/models/Registro.php';
require 'app/models/ImageComp.php';
require 'app/models/Asistencia.php';
class TestController{
    private $log;
    private $registro;
    private $imagecomp;
    private $asistencia;
    public function __construct()
    {
        $this->log = new Log();
        $this->registro = new Registro();
        $this->imagecomp = new ImageComp();
        $this->asistencia = new Asistencia();
    }

    public function registrar(){
        $message = "test ok";
        try{
            foreach ($_POST as $clave => $valor){
                $valor = $clave . " => " . $valor;
                $this->log->insert('POST: ' . $valor, date('Y-m-d H:i:s'));
            }

            foreach ($_GET as $clave => $valor){
                $valor = $clave . " => " . $valor;
                $this->log->insert('GET: ' . $valor, date('Y-m-d H:i:s'));
            }
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
            $message = $e->getMessage();
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response);
        echo json_encode($data);
    }
}
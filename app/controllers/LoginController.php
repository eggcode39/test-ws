<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 18/11/2019
 * Time: 17:38
 */
require 'app/models/Login.php';
class LoginController{
    private $log;
    private $login;
    public function __construct()
    {
        $this->log = new Log();
        $this->login = new Login();
    }

    public function iniciar_sesion(){
        try{
            //If All OK, the message does not change
            $message = "We did it. Your awesome... and beatiful";
            if(isset($_POST['user']) && isset($_POST['pass'])){
                $usuario = $this->login->login($_POST['user'], $_POST['pass']);
                if(!$usuario){
                    $user = [];
                    $result = 3;
                    $message = "Code 3: Credenciales Incorrectas";
                } else {
                    $user = array(
                        "usuario" => $usuario->cUsuario,
                        "nombre" => $usuario->cNombres,
                        "apellidos" => $usuario->cApellidos
                    );
                    $result = 1;
                }
            } else {
                $user = [];
                $result = 6;
                $message = "Code 6: Datos No Recibidos";
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $user = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $user);
        echo json_encode($data);
    }
}
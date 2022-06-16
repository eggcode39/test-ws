<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 18/11/2019
 * Time: 19:32
 */
require 'app/models/Registro.php';
require 'app/models/ImageComp.php';
require 'app/models/Asistencia.php';
class RegistroController{
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
        try{
            $model = new Registro();
            $model2 = new Registro();
            $fecha = date("Y-m-d H:i:s");
            //If All OK, the message does not change
            $message = "Code 1: Ok, Code 2: Error al crear Usuario";
            if(isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['dni']) && isset($_POST['direccion']) && isset($_POST['email']) && isset($_POST['telefono']) && isset($_POST['sexo']) && isset($_POST['user']) && isset($_POST['pass']) ){
                $model->cNombres = $_POST['nombres'];
                $model->cApellidos = $_POST['apellidos'];
                $model->cDNI = $_POST['dni'];
                $model->cDireccion = $_POST['direccion'];
                //$model->cTipo = $_POST['tipo'];
                $model->cEmail = $_POST['email'];
                $model->cTelefono = $_POST['telefono'];
                $model->cSexo = $_POST['sexo'];
                $model->dFechaReg = $fecha;
                $nueva_persona = $this->registro->registrar_persona($model);
                if($nueva_persona == 1){
                    $persona = $this->registro->obtener_persona_registro($fecha);
                    $model2->idPersona = $persona->idPersona;
                    $model2->cUsuario = $_POST['user'];
                    $model2->cPassword = $_POST['pass'];
                    $model2->dFecReg = $fecha;
                    $result = $this->registro->registrar_usuario($model2);
                } else {
                    $result = 2;
                    $message = "Code 2: Persona No Creada";
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
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function registrar_docente(){
        try{
            $model = new Registro();
            $model2 = new Registro();
            $fecha = date("Y-m-d H:i:s");
            //If All OK, the message does not change
            $message = "Code 1: Ok, Code 2: Error al crear Usuario";
            if(isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['dni']) && isset($_POST['direccion']) && isset($_POST['tipo']) && isset($_POST['email']) && isset($_POST['telefono']) && isset($_POST['sexo']) && isset($_POST['nivel']) && isset($_POST['turno'])){
                $model->cNombres = $_POST['nombres'];
                $model->cApellidos = $_POST['apellidos'];
                $model->cDNI = $_POST['dni'];
                $model->cDireccion = $_POST['direccion'];
                $model->cTipo = $_POST['tipo'];
                $model->cEmail = $_POST['email'];
                $model->cTelefono = $_POST['telefono'];
                $model->cSexo = $_POST['sexo'];
                $model->dFechaReg = $fecha;
                $nueva_persona = $this->registro->registrar_persona($model);
                if($nueva_persona == 1){
                    $persona = $this->registro->obtener_persona_registro($fecha);
                    $model2->idPersona = $persona->idPersona;
                    $model2->cNivel = $_POST['nivel'];
                    $model2->cTurno = $_POST['turno'];
                    $model2->cFecReg = $fecha;
                    $result = $this->registro->registrar_docente($model2);
                } else {
                    $result = 2;
                    $message = "Code 2: Persona No Creada";
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
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function listar_docentes(){
        try{
            //If All OK, the message does not change
            $message = "We did it. Your awesome... and beatiful";
            $datos = $this->registro->listar_docentes();
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $datos = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $datos);
        echo json_encode($data);
    }

    public function registrar_asistencia(){
        $datos = [];
        try{
            $model = new Registro();
            //If All OK, the message does not change
            $message = "Code 1: Ok, Code 2: Error al crear Usuario";
            if(isset($_POST['id_persona']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['turno']) && isset($_POST['tipo'])){
                $model->idPersona = $_POST['id_persona'];
                $model->dFecha = $_POST['fecha'];
                $model->dHora = $_POST['hora'];
                $model->cTurno = $_POST['turno'];
                $model->tipo = $_POST['tipo'];

                $nombre_foto = $_POST['fecha'] . '-'. $_POST['hora'];
                $model->ubicacion_x = $_POST['ubicacion_x'];
                $model->ubicacion_nombre = $_POST['ubicacion_nombre'];
                $model->ubicacion_y = $_POST['ubicacion_y'];

                $file_path = "media/asistencia/".$nombre_foto.".jpg";
                file_put_contents($file_path, base64_decode($_POST['foto']));
                $model->foto = $file_path;


                $result = $this->registro->registrar_asistencia2($model);
                if($result == 1){
                    $datos = $this->registro->listar_asistencia_persona($_POST['id_persona'], $_POST['fecha'], $_POST['hora']);
                }
            } else {
                $result = 6;
                $message = "Code 6: Datos No Recibidos";
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $datos);
        echo json_encode($data);
    }

    public function registrar_justificacion(){
        try{
            $model = new Registro();
            //If All OK, the message does not change
            $message = "Code 1: Ok, Code 2: Error al crear Usuario";
            if(isset($_POST['id_persona']) && isset($_POST['fecha']) && isset($_POST['tipo']) && isset($_POST['detalle']) && isset($_POST['fecha_justificacion'])){
                $model->idPersona = $_POST['id_persona'];
                $model->dFecha = $_POST['fecha'];
                $model->fecha_justificacion = $_POST['fecha_justificacion'];
                $model->cTipo = $_POST['tipo'];
                $model->cDetalle = $_POST['detalle'];
                $result = $this->registro->registrar_justificacion($model);
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
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function listar_justificacion_dia(){
        try{
            //If All OK, the message does not change
            $message = "We did it. Your awesome... and beatiful";
            if(isset($_POST['fecha'])){
                $datos = $this->registro->listar_justificacion($_POST['fecha']);
                $result = 1;
            } else {
                $datos = [];
                $result = 6;
                $message = "Code 6: Datos No Recibidos";
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $datos = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $datos);
        echo json_encode($data);
    }

    public function listar_justificacion(){
        try{
            $message = "We did it. Your awesome... and beatiful";
            $fechas = $this->registro->listar_fechas_justificacion();
            $i = 0;
            foreach ($fechas as $f){
                //$datos[] = $f->fecha;
                $docentes = $this->registro->listar_justificacion($f->fecha);
                $datos[$i]['fecha'] = $f->fecha;
                $datos[$i]['docentes'] = $docentes;
                /*foreach ($docentes as $d){
                    $datos[$f->fecha][] = $d;
                }*/
                $i++;
            }
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $datos = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        //$response = array("code" => $result,"message" => $message);
        $data = array("result" => $datos);
        echo json_encode($data);
    }

    public function listar_asistencia_persona(){
        try{
            //If All OK, the message does not change
            $message = "We did it. Your awesome... and beatiful";
            if(isset($_POST['id_persona']) && isset($_POST['fecha']) && isset($_POST['hora'])){
                $datos = $this->registro->listar_asistencia_persona($_POST['id_persona'], $_POST['fecha'], $_POST['hora']);
                $result = 1;
            } else {
                $user = [];
                $result = 6;
                $message = "Code 6: Datos No Recibidos";
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $datos = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $datos);
        echo json_encode($data);
    }

    public function listar_asistencia_dia(){
        try{
            //If All OK, the message does not change
            $message = "We did it. Your awesome... and beatiful";
            if(isset($_POST['fecha'])){
                $datos = $this->registro->listar_asistencia_dia($_POST['fecha']);
                $result = 1;
            } else {
                $datos = [];
                $result = 6;
                $message = "Code 6: Datos No Recibidos";
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $datos = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $datos);
        echo json_encode($data);
    }

    public function listar_asistencia_dia_turno(){
        try{
            //If All OK, the message does not change
            $message = "We did it. Your awesome... and beatiful";
            if(isset($_POST['fecha']) && isset($_POST['turno'])){
                $datos = $this->registro->listar_asistencia_dia_turno($_POST['fecha'],$_POST['turno']);
                $result = 1;
            } else {
                $datos = [];
                $result = 6;
                $message = "Code 6: Datos No Recibidos";
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $datos = [];
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response, "data" => $datos);
        echo json_encode($data);
    }

    public function registrar_foto(){
        try{
            $model = new Registro();
            //If All OK, the message does not change
            $message = "Code 1: Ok, Code 2: Error al crear Usuario";

            $model->idAsistencia = $_POST['id_asistencia'];
            $model->ubicacion_x = $_POST['ubicacion_x'];
            $model->ubicacion_nombre = $_POST['ubicacion_nombre'];
            $model->ubicacion_y = $_POST['ubicacion_y'];

            $file_path = "media/asistencia/".$_POST['id_asistencia'].".jpg";
            file_put_contents($file_path, base64_decode($_POST['foto']));
            $model->foto = $file_path;
            /*if($_FILES['foto']['tmp_name']!= null){
                $model->foto = "media/asistencia/".$_POST['id_asistencia'].".jpg";
                $file_path_t = "tmp/asistencia/".$_POST['id_asistencia'].".jpg";
                move_uploaded_file($_FILES['foto']['tmp_name'],$file_path_t);
                $file_path = "media/asistencia/".$_POST['id_asistencia'].".jpg";
                if($this->imagecomp->redimensionarImagen($file_path_t, $file_path, false)){
                    $model->foto = $file_path;
                } else {
                    $model->foto = "";
                }
            }else{
                $model->file_foto = "";
            }*/

            $result = $this->registro->registrar_foto($model);

        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
            $message = "Code 2: General Error";
        }
        $response = array("code" => $result,"message" => $message);
        $data = array("result" => $response);
        echo json_encode($data);
    }

    public function pdf_asistencia(){
        try{
            $docentes = $this->registro->listar_asistencia_dia($_POST['fecha']);
            require _VIEW_PATH_ . 'cabecera.php';
            require _VIEW_PATH_ . 'asistencia_pdf.php';
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = "ERROR";
        }
    }

    public function listar_asistencias_entrada(){
        $datos = [];
        try{
            $message = "We did it. Your awesome... and beatiful";
            $fechas = $this->registro->listar_fechas_asistencia();
            $i = 0;
            foreach ($fechas as $f){
                //$datos[] = $f->fecha;
                $docentes = $this->registro->listar_asistencia_dia_entrada($f->fecha);
                $datos[$i]['fecha'] = $f->fecha;
                $datos[$i]['docentes'] = $docentes;

                /*foreach ($docentes as $d){
                    $datos[$f->fecha][] = $d;
                }*/
                $i++;
            }
            $result = 1;
        }catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
            $message = "Code 2: General Error";
        }
        //$response = array("code" => $result,"message" => $message);
        $data = array("result" => $datos);
        echo json_encode($data);
    }

    public function listar_asistencias_salida(){
        $datos = [];
        try{
            $message = "We did it. Your awesome... and beatiful";
            $fechas = $this->registro->listar_fechas_asistencia();
            $i = 0;
            foreach ($fechas as $f){
                //$datos[] = $f->fecha;
                $docentes = $this->registro->listar_asistencia_dia_salida($f->fecha);
                $datos[$i]['fecha'] = $f->fecha;
                $datos[$i]['docentes'] = $docentes;

                /*foreach ($docentes as $d){
                    $datos[$f->fecha][] = $d;
                }*/
                $i++;
            }
            $result = 1;
        }catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
            $message = "Code 2: General Error";
        }
        //$response = array("code" => $result,"message" => $message);
        $data = array("result" => $datos);
        echo json_encode($data);
    }

    public function pdf_asistencia_fechas(){
        try{
            $inicio = $_POST['inicio'];
            $fin = $_POST['fin'];
            /*$inicio = '2019-12-18';
            $fin = '2019-12-19';*/
            $fechas = $this->asistencia->listar_fechas_asistencia_filtro($inicio, $fin);
            $docentes = $this->registro->listar_docentes();
            require _VIEW_PATH_ . 'cabecera.php';
            require _VIEW_PATH_ . 'asistencia_pdf.php';
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = "ERROR";
        }
    }
}
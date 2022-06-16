<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 25/12/2019
 * Time: 23:05
 */
class Asistencia{
    private $pdo;
    private $log;
    public function __construct(){
        $this->log = new Log();
        $this->pdo = Database::getConnection();
    }

    public function listar_fechas_asistencia_filtro($inicio, $fin){
        try{
            $sql = "select distinct dFecha fecha from asistencia where dFecha between ? and ? order by dFecha asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$inicio, $fin]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_docente_entrada_dia($id, $fecha){
        try{
            $sql = "select idAsistencia id, dHora hora, cTurno turno from asistencia where idPersona = ? and dFecha = ? and tipo = 'ENTRADA' limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id, $fecha]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_docente_salida_dia($id, $fecha){
        try{
            $sql = "select idAsistencia id, dHora hora, cTurno turno from asistencia where idPersona = ? and dFecha = ? and tipo = 'SALIDA' limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id, $fecha]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}
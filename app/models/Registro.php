<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 18/11/2019
 * Time: 18:59
 */
class Registro{
    private $pdo;
    private $log;
    public function __construct(){
        $this->log = new Log();
        $this->pdo = Database::getConnection();
    }

    public function registrar_usuario($model){
        try{
            $sql = "insert into usuarios (idPersona, cUsuario, cPassword, cEstado, dFecReg) values (?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->idPersona,
                $model->cUsuario,
                $model->cPassword,
                1,
                $model->dFecReg,
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function registrar_persona($model){
        try{
            $sql = "insert into persona (cNombres, cApellidos, cDNI, cDireccion, cEmail, cTelefono, cSexo, nEstado, dFechaReg) values (?,?,?,?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->cNombres,
                $model->cApellidos,
                $model->cDNI,
                $model->cDireccion,
                $model->cEmail,
                $model->cTelefono,
                $model->cSexo,
                1,
                $model->dFechaReg
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function obtener_persona_registro($dFechaReg){
        try{
            $sql = "select * from persona where dFechaReg = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$dFechaReg]);
            $result = $stm->fetch();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function registrar_docente($model){
        try{
            $sql = "insert into docentes (idPersona, cNivel, cTurno, cEstado, dFecReg) values (?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->idPersona,
                $model->cNivel,
                $model->cTurno,
                1,
                $model->cFecReg
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_docentes(){
        try{
            $sql = "select * from persona p inner join docentes d on p.idPersona = d.idPersona";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function registrar_asistencia($model){
        try{
            $sql = "insert into asistencia (idPersona, dFecha, dHora, cTurno, tipo) values (?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->idPersona,
                $model->dFecha,
                $model->dHora,
                $model->cTurno,
                $model->tipo
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function registrar_asistencia2($model){
        try{
            $sql = "insert into asistencia (idPersona, dFecha, dHora, cTurno, tipo, ubicacion_x, ubicacion_y, ubicacion_nombre, foto) values (?,?,?,?,?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->idPersona,
                $model->dFecha,
                $model->dHora,
                $model->cTurno,
                $model->tipo,
                $model->ubicacion_x,
                $model->ubicacion_y,
                $model->ubicacion_nombre,
                $model->foto
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function registrar_justificacion($model){
        try{
            $sql = "insert into justificacion (idPersona, dFecha, cTipo, cDetalle, fecha_justificacion) values (?,?,?,?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->idPersona,
                $model->dFecha,
                $model->cTipo,
                $model->cDetalle,
                $model->fecha_justificacion
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_asistencia_persona($id, $fecha, $hora){
        try{
            $sql = "select * from asistencia where idPersona = ? and dFecha = ? and dHora = ? limit 1";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id,
                $fecha,
                $hora
            ]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_dia_entrada($fecha){
        try{
            $sql = "select * from asistencia a inner join persona p on a.idPersona = p.idPersona inner join docentes d on p.idPersona = d.idPersona where a.dFecha = ? and tipo = 'ENTRADA'";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $fecha
            ]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_dia($fecha){
        try{
            $sql = "select * from asistencia a inner join persona p on a.idPersona = p.idPersona inner join docentes d on p.idPersona = d.idPersona where a.dFecha = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $fecha
            ]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_dia_salida($fecha){
        try{
            $sql = "select * from asistencia a inner join persona p on a.idPersona = p.idPersona inner join docentes d on p.idPersona = d.idPersona where a.dFecha = ? and tipo = 'SALIDA'";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $fecha
            ]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_asistencia_dia_turno($fecha, $turno){
        try{
            $sql = "select * from asistencia a inner join persona p on a.idPersona = p.idPersona inner join docentes d on p.idPersona = d.idPersona where a.dFecha = ? and a.cTurno = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $fecha, $turno
            ]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_justificacion($fecha){
        try{
            $sql = "select * from justificacion j inner join persona p on j.idPersona = p.idPersona inner join docentes d on p.idPersona = d.idPersona where j.fecha_justificacion = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $fecha
            ]);
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function registrar_foto($model){
        try{
            $sql = "update asistencia set
                ubicacion_x = ?,
                ubicacion_y = ?,
                ubicacion_nombre = ?,
                foto = ?
                where idAsistencia = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $model->ubicacion_x,
                $model->ubicacion_y,
                $model->ubicacion_nombre,
                $model->foto,
                $model->idAsistencia,
            ]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

    public function listar_fechas_asistencia(){
        try{
            $sql = "select distinct dFecha fecha from asistencia order by dFecha asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

    public function listar_fechas_justificacion(){
        try{
            $sql = "select distinct fecha_justificacion fecha from justificacion order by dFecha asc";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll();
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }
}
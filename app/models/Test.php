<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE
 * Date: 22/06/2022
 * Time: 16:05
 */
class Test{
    private $pdo;
    private $log;
    public function __construct(){
        $this->log = new Log();
        $this->pdo = Database::getConnection();
    }

    public function guardar($valor){
        try{
            $sql = "insert into datitos (datos_valor, datos_fecha) values (?,?)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$valor, date('Y-m-d H:i:s')]);
            $result = 1;
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 18/11/2019
 * Time: 17:42
 */
class Login{
    private $pdo;
    private $log;
    public function __construct(){
        $this->log = new Log();
        $this->pdo = Database::getConnection();
    }

    public function login($user, $pass){
        try{
            $sql = "select * from usuarios u inner join persona p on u.idPersona = p.idPersona where  u.cUsuario = ? and u.cPassword = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$user, $pass]);
            $r = $stm->fetch();
            if(isset($r->cUsuario)){
                $result = $r;
            } else {
                $result = false;
            }
        } catch (Exception $e){
            $this->log->insert($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = false;
        }
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 18/11/2019
 * Time: 15:07
 */
class Log{
    public function __construct()
    {
        //Ruta de carpeta(Con año)
        $this->path     = "log/" . date("Y");
        //Ruta de carpeta(Con año y mes)
        $this->pathfull = $this->path  . "/" . date("m") ;
        //Nonbre del archivo
        $this->filename = "log-";
        //Fecha actual
        $this->date     = date("Y-m-d");
        //Hora actual
        $this->hour     = date('H:i:s');
        //IP donde se registra el error
        $this->ip       = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
    }

    //Funcion para insertar texto en el archivo de log del dia
    public function insert($text, $location)
    {
        //Crea la linea de texto que se va a insertar en el archivo
        $log    = $this->date . " " . $this->hour . "[UTC -5] [ip] " . $this->ip . " [location] " . $location . " [text] " . $text . PHP_EOL;
        //If para verificar si la carpeta año y mes indicados existen
        if(is_dir($this->pathfull)){
            //Si existen, file_put_contents ingresa la informacion sobre el archivo del dia, y si no existe, lo crea
            $result = (file_put_contents($this->pathfull . "/" . $this->filename . $this->date . ".txt", $log, FILE_APPEND)) ? 1 : 0;
        } else {
            //Si no existe el directorio completo, verifica si la carpeta del año correspondiente
            if(is_dir($this->path)){
                //Si existe, crea la carpeta del mes correspondiente, crea el archivo del dia y ingresa la información
                mkdir($this->pathfull, 0700);
                $result = (file_put_contents($this->pathfull . "/" . $this->filename . $this->date . ".txt", $log, FILE_APPEND)) ? 1 : 0;
            } else {
                //Si no existe la carpeta del año, crea la carpeta del año correspondiente, del mes, el archivo del dia y ingresa la información
                mkdir($this->path, 0700);
                mkdir($this->pathfull, 0700);
                $result = (file_put_contents($this->pathfull . "/" . $this->filename . $this->date . ".txt", $log, FILE_APPEND)) ? 1 : 0;
            }
        }
        return $result;
    }

}